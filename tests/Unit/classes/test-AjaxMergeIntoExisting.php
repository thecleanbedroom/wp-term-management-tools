<?php

namespace Tests\Unit;

use CNMD\TMT\TermManagementTools;

class test_AjaxMergeIntoExisting extends \WP_Ajax_UnitTestCase {

    public function setUp() {
        parent::setUp();
        // Ensure plugin is loaded by bootstrap; nothing else here.
        $this->factory()->user->create_and_get();
    }

    public function test_ajax_forbidden_without_caps() {
        // Create a subscriber (no manage_terms caps for categories by default).
        $user_id = $this->factory()->user->create( array( 'role' => 'subscriber' ) );
        wp_set_current_user( $user_id );

        $_POST['nonce']    = wp_create_nonce( 'tmt_merge_into_existing' );
        $_POST['taxonomy'] = 'category';
        $_POST['source_ids'] = array( 1 );
        $_POST['target_id']  = 1;

        try {
            $this->_handleAjax( 'tmt_merge_into_existing' );
        } catch ( \WPAjaxDieContinueException $e ) {}

        $response = json_decode( $this->_last_response, true );
        $this->assertEquals( 'error', $response['success'] ? 'success' : 'error' );
    }

    public function test_ajax_success_with_admin() {
        // Create terms in category taxonomy
        $t1 = wp_insert_term( 'Cat A', 'category' );
        $t2 = wp_insert_term( 'Cat B', 'category' );

        $user_id = $this->factory()->user->create( array( 'role' => 'administrator' ) );
        wp_set_current_user( $user_id );

        $_POST['nonce']    = wp_create_nonce( 'tmt_merge_into_existing' );
        $_POST['taxonomy'] = 'category';
        $_POST['source_ids'] = array( (int) $t2['term_id'] );
        $_POST['target_id']  = (int) $t1['term_id'];

        try {
            $this->_handleAjax( 'tmt_merge_into_existing' );
        } catch ( \WPAjaxDieContinueException $e ) {}

        $response = json_decode( $this->_last_response, true );
        $this->assertTrue( isset( $response['success'] ) );
    }
}
