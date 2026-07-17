# Root Cause Analysis and Fix Plan for Currency and Encoding Corruption

## Goal
Perform a comprehensive cleanup of the codebase to fix the corrupted characters (`?`, `à,-`, etc.), replace all currency instances with `DH`, and ensure all files are cleanly encoded in UTF-8 without BOM.

## Root Cause Analysis
The corruption occurred in two stages during previous text replacements:
1. **Double Encoding**: A PowerShell script read UTF-8 files using the default Windows-1252 encoding and saved them back as UTF-8. This double-encoded all multi-byte characters (e.g., `é` became `Ã©`, and `€` was mangled).
2. **Lossy Reversal**: A subsequent PHP script attempted to reverse this by converting from UTF-8 back to ISO-8859-1. While this successfully restored standard French accents (`é`, `à`), it permanently destroyed characters that do not exist in the ISO-8859-1 character set. Specifically:
   - The UTF-8 BOM (Byte Order Mark) at the start of files was replaced with a literal `?`.
   - The Euro symbol (`€`) was replaced with a literal `?`.
   - Any other non-ISO-8859-1 characters (like `œ`) were also replaced with `?`.

This is why files now start with `?@php` or `?<!DOCTYPE html>`, and why the currency displays as `?` in some places.

## Proposed Changes
I will run a precise PHP cleanup script across all project files (`.php`, `.js`, `.css`, `.env`, `.json`, `.md`) that will:
1. **Remove Corrupted BOM**: Detect and remove the literal `?` at the very beginning of any file (e.g., fixing `?@php` to `@php`).
2. **Remove Actual BOM**: Ensure no hidden UTF-8 BOM bytes (`\xEF\xBB\xBF`) remain, saving everything as clean UTF-8.
3. **Fix Currency Display**: Target `{{ number_format(...) }} ?` and similar broken currency strings, replacing them securely with `DH`.
4. **Fix Rogue Characters**: Scan for and replace any remaining `à,-`, `â‚¬`, or isolated `?` that are clearly meant to be currency symbols.
5. **Verify Meta Tags & DB**: Confirm `<meta charset="utf-8">` is present in layout files and `config/database.php` uses `utf8mb4`.

## Verification Plan
### Automated Tests
- Re-run the compiled views clearer: `php artisan view:clear`.
- Run a scan searching for literal `?@php` or `?<` at the start of files to guarantee the BOM corruption is gone.
- Run a scan for `€` or `à,-` to ensure no traces remain.

### Manual Verification
- Ask the user to browse to the dashboard, room service, reservations, and staff orders to verify the Dirham (`DH`) displays cleanly and the HTML renders without a rogue `?` at the top of the page.

> [!IMPORTANT]  
> User Review Required: Please review this root cause analysis and approve the plan. Once approved, I will execute the cleanup script and verify the fixes.
