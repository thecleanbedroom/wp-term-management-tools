# TODO: Add "Merge into Existing" Option

- [x] **UI Changes**: Add new option to merge dropdown in `assets/src/script.js` and implement dynamic second dropdown populated via AJAX.
- [x] **Backend Endpoint**: Implement `merge_into_existing` in `classes/class-Handlers.php` (bulk POST flow via `dispatcher()` handles nonce and capabilities).
- [x] **Merge Logic**: Add wrapper method `merge_into_existing( $source_ids, $target_id )` in `class-TermManagementTools.php` and fire appropriate hooks.
- [x] **AJAX Registration**: Register AJAX action `wp_ajax_tmt_merge_into_existing` (and optionally `wp_ajax_nopriv_`).
- [x] **Permissions & Security**: Ensure user capability `manage_options` (or custom) and use `check_ajax_referer`.
- [x] **Unit Tests**: Create `tests/Unit/classes/TestMergeIntoExisting.php` covering success, errors, permissions, and category list retrieval.
- [x] **Documentation**: Update `README.md` and add usage screenshots section in this docs folder.
- [x] **Internationalisation**: Add translation strings for new UI elements and generate updated `.po/.mo` files.
- [x] **Code Review & QA**: Verify no regressions, all tests pass, and acceptance criteria are met.
