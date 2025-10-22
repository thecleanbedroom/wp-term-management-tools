<?php

namespace Tests\Unit;

use CNMD\TMT\HTML;

class test_HTMLMergeIntoExisting extends TestCase {

    public function setUp() {
        parent::setUp();
        $this->clean_taxonomy( 'category' );
    }

    public function tearDown() {
        $this->clean_taxonomy( 'category' );
        parent::tearDown();
    }

    public function test_merge_into_existing_dropdown_contains_terms() {
        global $taxonomy;
        $taxonomy = 'category';

        $cats = $this->add_terms( $taxonomy, 2 );

        $html = new HTML();

        ob_start();
        $html->insert();
        $output = ob_get_clean();

        $this->assertStringContainsString('name="merge_into_existing_target"', $output);
        $this->assertStringContainsString('value="' . $cats[0] . '"', $output);
        $this->assertStringContainsString('value="' . $cats[1] . '"', $output);
    }
}
