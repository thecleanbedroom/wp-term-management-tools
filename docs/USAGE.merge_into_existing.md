# Merge into Existing — Usage Guide

## Overview
Use this bulk action to merge selected terms into an existing target term within the same taxonomy.

## Steps
1. Navigate to the taxonomy admin list (e.g., WP-Admin → Posts → Categories or Tags).
2. Select the source terms you want to merge.
3. Choose "Merge into Existing" in the Bulk Actions dropdown.
4. In the dropdown that appears, select the existing target term.
5. Click Apply.

## Behavior
- If all source terms share the same parent (hierarchical taxonomies), the target term will inherit that parent.
- Posts formerly assigned to each source term will be reassigned to the target term.
- Source terms are deleted after reassignment.
- A notice "Terms updated." will be shown upon success.

## Permissions & Security
- Action requires a user capable of managing terms for the selected taxonomy.
- Requests are protected by a nonce. Invalid nonces or insufficient permissions cause the operation to fail.

## Screenshots (placeholders)
- Screenshot A: Bulk Actions menu showing "Merge into Existing".
- Screenshot B: The category dropdown next to the Bulk Actions menu after choosing the action.
- Screenshot C: Success notice after performing the merge.

