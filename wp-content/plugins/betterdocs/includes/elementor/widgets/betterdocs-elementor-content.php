<?php

use ElementorPro\Modules\ThemeBuilder\Widgets\Post_Content;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class BetterDocs_Elementor_Content extends Post_Content {

    public function get_name() {
        return 'betterdocs-content';
    }

    public function get_title() {
        return __( 'Doc Content', 'betterdocs' );
    }

    public function get_icon() {
        return 'betterdocs-icon-Content';
    }

    public function get_categories() {
        return [ 'betterdocs-elements' ];
    }

    public function get_keywords() {
        return [ 'betterdocs-elements', 'content', 'description', 'docs', 'betterdocs' ];
    }

    public function get_custom_help_url() {
        return 'https://betterdocs.co/docs/single-doc-in-elementor';
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Style', 'betterdocs' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
        $this->add_control(
			'print_btn',
			[
				'label' => __( 'Print Button', 'betterdocs' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'betterdocs' ),
				'label_off' => __( 'Hide', 'betterdocs' ),
				'return_value' => '1',
				'default' => '1',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'betterdocs' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'betterdocs' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'betterdocs' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'betterdocs' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'betterdocs' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
	}
	

    protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute('betterdocs-content', 'id', ['betterdocs-single-content']);
		$this->add_render_attribute('betterdocs-content', 'class', ['betterdocs-entry-content']);
		if($settings['print_btn'] == 1) {
			echo '<div class="betterdocs-print-pdf">
				<span class="betterdocs-print-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" width="20px"><path fill="#66798f" d="M14 16H66V24H14z"></path><path fill="#b0c1d4" d="M8,63.5c-3,0-5.5-2.5-5.5-5.5V26c0-3,2.5-5.5,5.5-5.5h64c3,0,5.5,2.5,5.5,5.5v32 c0,3-2.5,5.5-5.5,5.5H8z"></path><path fill="#66798f" d="M72,21c2.8,0,5,2.2,5,5v32c0,2.8-2.2,5-5,5H8c-2.8,0-5-2.2-5-5V26c0-2.8,2.2-5,5-5H72 M72,20H8 c-3.3,0-6,2.7-6,6v32c0,3.3,2.7,6,6,6h64c3.3,0,6-2.7,6-6V26C78,22.7,75.3,20,72,20L72,20z"></path><path fill="#fff" d="M16.5 2.5H63.5V23.5H16.5z"></path><path fill="#788b9c" d="M63,3v20H17V3H63 M64,2H16v22h48V2L64,2z"></path><path fill="#8bb7f0" d="M22,41.5c-3,0-5.5-2.5-5.5-5.5V20.5h47V36c0,3-2.5,5.5-5.5,5.5H22z"></path><path fill="#4e7ab5" d="M63,21v15c0,2.8-2.2,5-5,5H22c-2.8,0-5-2.2-5-5V21H63 M64,20H16v16c0,3.3,2.7,6,6,6h36 c3.3,0,6-2.7,6-6V20L64,20z"></path><path fill="#fff" d="M16.5 50.5H63.5V77.5H16.5z"></path><path fill="#788b9c" d="M63,51v26H17V51H63 M64,50H16v28h48V50L64,50z"></path><path fill="#d6e3ed" d="M17 52H63V56H17z"></path><path fill="#788b9c" d="M26 59H54V60H26zM26 67H54V68H26z"></path><g><path fill="#ffeea3" d="M70 28A2 2 0 1 0 70 32A2 2 0 1 0 70 28Z"></path></g><path fill="#66798f" d="M17,56v-4h46v4h2c1.7,0,3-1.3,3-3l0,0c0-1.7-1.3-3-3-3H15c-1.7,0-3,1.3-3,3l0,0c0,1.7,1.3,3,3,3H17z"></path></svg></span>
			</div>';
		}
        echo '<div '.$this->get_render_attribute_string('betterdocs-content').'>';

            $toc_setting = get_transient('betterdocs_toc_setting');
			$htags = ($toc_setting) ? implode(',', $toc_setting['htags']) : '';
			$enable_toc = ($htags) ? 1 : '';
			$content = apply_filters('the_content', get_the_content());
			$shortcode = BetterDocs_Public::betterdocs_the_content(
				$content,
				$htags,
				$enable_toc
			);

            echo apply_filters('betterdocs_elementor_docs_content', $shortcode);
        echo '</div>';
    }

    public function show_in_panel() {
        // By default don't show.
        return true;
    }


}
