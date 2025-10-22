# Plan: Add "Merge into Existing" Option

## Overview
We will extend the **Term Management Tools** plugin with a new merge strategy called **"Merge into Existing"**. This option will appear in the existing merge dropdown and allow the user to select an existing category (term) to merge the selected terms into.

## Goals
- Add a new merge option label **"Merge into Existing"**.
- When selected, display a dropdown populated with existing categories/terms.
- Preserve current merge behaviours (e.g., "Merge into New").
- Ensure UI/UX consistency with existing options.
- Write unit tests for the new flow.
- Update documentation and README.

## Technical Tasks

### 1. UI Changes
- **File:** `assets/src/script.js` (or appropriate admin JS file).
- Add a new option to the merge dropdown:
  ```html
  <option value="merge_into_existing">Merge into Existing</option>
  ```
- When this option is selected, dynamically show a second dropdown (`#existing-category-select`).
- Populate the second dropdown via AJAX call to fetch existing categories.
- Ensure the new UI elements are hidden/shown appropriately.

### 2. Backend Endpoint
- **File:** `classes/class-Handlers.php` (or similar handler class).
- Create a new AJAX handler `handle_merge_into_existing`.
- Validate nonce and user capabilities.
- Accept `source_term_ids` and `target_term_id`.
- Perform the merge logic using existing term‑management functions.
- Return JSON success/error response.

### 3. Merge Logic
- Reuse existing merge functions from `class-TermManagementTools.php`.
- Add a wrapper method `merge_into_existing( $source_ids, $target_id )` that:
  1. Loops through source IDs.
  2. Reassigns posts, meta, etc., to the target term.
  3. Deletes source terms if appropriate.
- Ensure hooks (`do_action('tmt_merge_into_existing')`) are fired for extensibility.

### 4. AJAX Registration
- Register the new AJAX action in `class-Handlers.php`:
  ```php
  add_action('wp_ajax_tmt_merge_into_existing', [ $this, 'handle_merge_into_existing' ]);
  ```
- Add a corresponding `wp_ajax_nopriv_` if needed (likely not, as only admins can merge).

### 5. Permissions & Security
- Verify the current user has `manage_options` or a custom capability.
- Use `check_ajax_referer` with the plugin’s nonce.

### 6. Unit Tests
- **File:** `tests/Unit/classes/TestMergeIntoExisting.php`
- Test successful merge, error handling, permission checks, and that the existing category list is correctly returned.

### 7. Documentation
- Update `README.md` with a description of the new option.
- Add a dedicated section in `docs/PLAN.mergeoption2.md` (this file) describing the implementation steps.
- Add usage screenshots (placeholder paths) for future UI docs.

### 8. Internationalisation
- Add translation strings for the new option label and UI messages in the `.pot` file.
- Run `wp i18n make-pot` to generate updated `.po/.mo` files.

## Timeline (Estimated)
| Phase | Duration |
|-------|----------|
| UI implementation | 1 day |
| Backend endpoint & merge logic | 1 day |
| AJAX wiring & security | 0.5 day |
| Unit tests | 0.5 day |
| Documentation & i18n | 0.5 day |
| Code review & QA | 0.5 day |
| **Total** | **~4 days** |

## Acceptance Criteria
- The merge dropdown now includes **"Merge into Existing"**.
- Selecting it reveals a populated category dropdown.
- Merging works identically to the existing "Merge into New" flow, moving all associated data.
- No regression in other plugin features.
- All unit tests pass (`phpunit`).
- Documentation reflects the new feature.

---
*Prepared by Cascade on 2025‑10‑22*
