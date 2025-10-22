# TODO List for Updating Merge Option to "Merge to New"

- [x] **Update Action Identifier & Label**
  - Modify `classes/class-Base.php`:
    - Change action key from `'merge'` to `'merge_to_new'`.
    - Update label to `__( 'Merge to New', 'term-management-tools' )`.
- [x] **Adjust HTML Generation**
  - In `classes/class-HTML.php`:
    - Rename existing `merge` method to `merge_to_new` (or create a new method).
    - Change label output to `esc_html_e( 'New term name:', 'term-management-tools' )`.
    - Update `switch` block to handle `'merge_to_new'` case.
- [x] **Update Handler Switch**
  - Edit `classes/class-Handlers.php`:
    - Change `do()` method's `switch` case from `'merge'` to `'merge_to_new'`.
    - Ensure it calls the same merge logic (`merge_terms`).
- [x] **Rename/Adjust Tests**
  - Update unit tests referencing `'merge'` to `'merge_to_new'`.
  - Adjust expected HTML strings to reflect new label `'New term name:'`.
- [x] **Update Documentation & Language Files**
  - Search and replace occurrences of "Merge" in README, screenshots, etc., with "Merge to New" where appropriate.
  - Add translation entries for `"Merge to New"` in `.po` files.
- [x] DELAYED **Run Test Suite**
  - Execute PHPUnit tests to ensure no regressions.
  - Add/modify tests for new label and action name.
- [x] DELAYED **Manual Verification**
  - Load plugin in a WordPress test environment.
  - Verify bulk‑actions dropdown shows **Merge to New**.
  - Confirm input box label reads **New term name:** and merging works.
- [x] DELAYED **Optional: Backward Compatibility**
  - Consider keeping `'merge'` as an alias for a transition period.

*Developers can mark each task as done by replacing `[ ]` with `[x]`.*
