<?php

namespace Tests\Unit;

use CNMD\TMT\Handlers;

class test_MergeIntoExisting extends TestCase {

    /** @var Handlers */
    private $handler;

    public function setUp() {
        parent::setUp();
        $this->handler = new Handlers();
        $this->create_sample_taxonomy__flat();
        $this->create_sample_taxonomy__hierarchical();
        $this->clean_taxonomy( 'post_tag' );
        $this->clean_taxonomy( 'category' );
    }

    public function tearDown() {
        remove_action( 'init', 'cnmd_ct_create_sample_taxonomy__flat', 0 );
        remove_action( 'init', 'cnmd_ct_create_sample_taxonomy__hierarchical', 0 );
        $this->handler = null;
        parent::tearDown();
    }

    public function test_merge_into_existing_flat_success() {
        global $_REQUEST;

        $taxonomy = 'post_tag';
        $term_ids = $this->add_terms( $taxonomy, 5 );
        $this->assertEquals( 5, count( $this->get_all_terms( $taxonomy ) ) );

        $target_id  = $term_ids[0];
        $source_ids = array_slice( $term_ids, 1 );

        $_REQUEST['merge_into_existing_target'] = $target_id;

        $ok = $this->handler->do( 'merge_into_existing', $taxonomy, $source_ids );
        $this->assertTrue( $ok );

        $terms = $this->get_all_terms( $taxonomy );
        $this->assertEquals( 1, count( $terms ) );
        $this->assertEquals( $target_id, $terms[0]->term_id );

        $this->clean_taxonomy( $taxonomy );
    }

    public function test_merge_into_existing_invalid_target_returns_false() {
        global $_REQUEST;

        $taxonomy = 'flat';
        $term_ids = $this->add_terms( $taxonomy, 3 );

        $_REQUEST['merge_into_existing_target'] = 99999; // non-existent
        $ok = $this->handler->do( 'merge_into_existing', $taxonomy, $term_ids );
        $this->assertFalse( $ok );

        $this->clean_taxonomy( $taxonomy );
    }

    public function test_merge_into_existing_hierarchical_preserves_parent_when_same() {
        global $_REQUEST;

        $taxonomy = 'hierarchical';
        $parent_ids = $this->add_terms( $taxonomy, 1 );
        $parent_id  = $parent_ids[0];
        $child_ids  = $this->add_terms( $taxonomy, 3, $parent_id );

        $target_ids = $this->add_terms( $taxonomy, 1, $parent_id );
        $target_id  = $target_ids[0];

        $_REQUEST['merge_into_existing_target'] = $target_id;
        $ok = $this->handler->do( 'merge_into_existing', $taxonomy, $child_ids );
        $this->assertTrue( $ok );

        $terms = $this->get_all_terms( $taxonomy );
        $this->assertEquals( 2, count( $terms ) );
        foreach ( $terms as $t ) {
            if ( $t->term_id === $target_id ) {
                $this->assertEquals( $parent_id, $t->parent );
            }
        }

        $this->clean_taxonomy( $taxonomy );
    }
}
