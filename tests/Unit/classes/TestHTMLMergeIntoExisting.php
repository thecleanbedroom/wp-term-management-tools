<?php

namespace Tests\Unit;

use CNMD\TMT\HTML;

class TestHTMLMergeIntoExisting extends TestCase {

    public function setUp() {
        parent::setUp();
        // Ensure categories exist and are empty for predictability
        $this->clean_taxonomy( 'category' );
    }

    public function tearDown() {
        $this->clean_taxonomy( 'category' );
        parent::tearDown();
    }

    public function test_merge_into_existing_dropdown_contains_terms() {
        global $taxonomy;
        $taxonomy = 'category';

        // Create two categories to appear in the dropdown
        $cats = $this->add_terms( $taxonomy, 2 );

        $html = new HTML();

        ob_start();
        $html->insert();
        $output = ob_get_clean();

        // Ensure the merge_into_existing block is present with correct name attribute
        $this->assertStringContainsString('name="merge_into_existing_target"', $output);

        // Ensure options include the created term IDs
        $this->assertStringContainsString('value="' . $cats[0] . '"', $output);
        $this->assertStringContainsString('value="' . $cats[1] . '"', $output);
    }
}
