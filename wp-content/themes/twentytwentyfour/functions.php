<?php
/**
 * Twenty Twenty-Four functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Four
 * @since Twenty Twenty-Four 1.0
 */

/**
 * Register block styles.
 */

if ( ! function_exists( 'twentytwentyfour_block_styles' ) ) :
	/**
	 * Register custom block styles
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */

function hs_give_me_coffee() {
    // URL of the Random Coffee API
    $api_url = 'https://api.sampleapis.com/coffee/hot';

    // Make a request to the API using the WordPress HTTP API
    $response = wp_remote_get($api_url);

    // Check for errors
    if (is_wp_error($response)) {
        return false;
    }

    // Get the response body
    $body = wp_remote_retrieve_body($response);

    // Decode the JSON data
    $data = json_decode($body);
	//print data to check jason format 
	//echo "<pre>";
	//print_r($data);
	//echo "</pre>";
	//exit();
    // Check if the JSON decoding was successful and contains coffee items
    if ($data && isset($data->coffee_items) && is_array($data->coffee_items)) {
        // Display only 5 items using a loop
		//echo "<pre>";
		//echo $data->coffee_items['title'];
		//echo "</pre>";
		//exit();
        $output = '<ul>';
        for ($i = 0; $i < min(5, count($data->coffee_items)); $i++) {
            $output .= '<li>';
            $output .= '<strong>Title:</strong> ' . esc_html($data->coffee_items[$i]->title) . '<br>';
            $output .= '<em>Description:</em> ' . esc_html($data->coffee_items[$i]->description) . '<br>';
            $output .= '<img src="' . esc_url($data->coffee_items[$i]->image) . '" alt="Coffee Image"><br>';
            $output .= '</li>';
        }
        $output .= '</ul>';

        return $output;
    } else {
        return false;
    }
}

	//Output the coffee items in a shortcode
function coffee_shortcode() {
    $coffee_output = hs_give_me_coffee();
    if ($coffee_output) {
        return $coffee_output;
    } else {
        return 'Failed to fetch coffee items.';
    }
}

add_shortcode('display_coffee', 'coffee_shortcode');

function get_kanye_quotes() {
    // URL of the Kanye.rest API
    $api_url = 'https://api.kanye.rest/';

    // Make a request to the API using the WordPress HTTP API
    $response = wp_remote_get($api_url);

    // Check for errors
    if (is_wp_error($response)) {
        return false;
    }

    // Decode the JSON data
    $data = json_decode(wp_remote_retrieve_body($response));

    // Check if the JSON decoding was successful
    if ($data && isset($data->quote)) {
        return $data->quote;
    } else {
        return false;
    }
}

function display_kanye_quotes() {
    // Display 5 Kanye quotes
    $output = '<ul>';
    for ($i = 0; $i < 5; $i++) {
        $quote = get_kanye_quotes();
        $output .= '<li>' . esc_html($quote) . '</li>';
    }
    $output .= '</ul>';

    return $output;
}

// Output the Kanye quotes in a shortcode
function kanye_quotes_shortcode() {
    $quotes_output = display_kanye_quotes();
    if ($quotes_output) {
        return $quotes_output;
    } else {
        return 'Failed to fetch Kanye quotes.';
    }
}

add_shortcode('kanye_quotes', 'kanye_quotes_shortcode');


	function twentytwentyfour_block_styles() {

		register_block_style(
			'core/details',
			array(
				'name'         => 'arrow-icon-details',
				'label'        => __( 'Arrow icon', 'twentytwentyfour' ),
				/*
				 * Styles for the custom Arrow icon style of the Details block
				 */
				'inline_style' => '
				.is-style-arrow-icon-details {
					padding-top: var(--wp--preset--spacing--10);
					padding-bottom: var(--wp--preset--spacing--10);
				}

				.is-style-arrow-icon-details summary {
					list-style-type: "\2193\00a0\00a0\00a0";
				}

				.is-style-arrow-icon-details[open]>summary {
					list-style-type: "\2192\00a0\00a0\00a0";
				}',
			)
		);
		register_block_style(
			'core/post-terms',
			array(
				'name'         => 'pill',
				'label'        => __( 'Pill', 'twentytwentyfour' ),
				/*
				 * Styles variation for post terms
				 * https://github.com/WordPress/gutenberg/issues/24956
				 */
				'inline_style' => '
				.is-style-pill a,
				.is-style-pill span:not([class], [data-rich-text-placeholder]) {
					display: inline-block;
					background-color: var(--wp--preset--color--base-2);
					padding: 0.375rem 0.875rem;
					border-radius: var(--wp--preset--spacing--20);
				}

				.is-style-pill a:hover {
					background-color: var(--wp--preset--color--contrast-3);
				}',
			)
		);
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfour' ),
				/*
				 * Styles for the custom checkmark list block style
				 * https://github.com/WordPress/gutenberg/issues/51480
				 */
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
		register_block_style(
			'core/navigation-link',
			array(
				'name'         => 'arrow-link',
				'label'        => __( 'With arrow', 'twentytwentyfour' ),
				/*
				 * Styles for the custom arrow nav link block style
				 */
				'inline_style' => '
				.is-style-arrow-link .wp-block-navigation-item__label:after {
					content: "\2197";
					padding-inline-start: 0.25rem;
					vertical-align: middle;
					text-decoration: none;
					display: inline-block;
				}',
			)
		);
		register_block_style(
			'core/heading',
			array(
				'name'         => 'asterisk',
				'label'        => __( 'With asterisk', 'twentytwentyfour' ),
				'inline_style' => "
				.is-style-asterisk:before {
					content: '';
					width: 1.5rem;
					height: 3rem;
					background: var(--wp--preset--color--contrast-2, currentColor);
					clip-path: path('M11.93.684v8.039l5.633-5.633 1.216 1.23-5.66 5.66h8.04v1.737H13.2l5.701 5.701-1.23 1.23-5.742-5.742V21h-1.737v-8.094l-5.77 5.77-1.23-1.217 5.743-5.742H.842V9.98h8.162l-5.701-5.7 1.23-1.231 5.66 5.66V.684h1.737Z');
					display: block;
				}

				/* Hide the asterisk if the heading has no content, to avoid using empty headings to display the asterisk only, which is an A11Y issue */
				.is-style-asterisk:empty:before {
					content: none;
				}

				.is-style-asterisk:-moz-only-whitespace:before {
					content: none;
				}

				.is-style-asterisk.has-text-align-center:before {
					margin: 0 auto;
				}

				.is-style-asterisk.has-text-align-right:before {
					margin-left: auto;
				}

				.rtl .is-style-asterisk.has-text-align-left:before {
					margin-right: auto;
				}",
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_styles' );

/**
 * Enqueue block stylesheets.
 */

if ( ! function_exists( 'twentytwentyfour_block_stylesheets' ) ) :
	/**
	 * Enqueue custom block stylesheets
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_block_stylesheets() {
		/**
		 * The wp_enqueue_block_style() function allows us to enqueue a stylesheet
		 * for a specific block. These will only get loaded when the block is rendered
		 * (both in the editor and on the front end), improving performance
		 * and reducing the amount of data requested by visitors.
		 *
		 * See https://make.wordpress.org/core/2021/12/15/using-multiple-stylesheets-per-block/ for more info.
		 */
		wp_enqueue_block_style(
			'core/button',
			array(
				'handle' => 'twentytwentyfour-button-style-outline',
				'src'    => get_parent_theme_file_uri( 'assets/css/button-outline.css' ),
				'ver'    => wp_get_theme( get_template() )->get( 'Version' ),
				'path'   => get_parent_theme_file_path( 'assets/css/button-outline.css' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_block_stylesheets' );

/**
 * Register pattern categories.
 */

if ( ! function_exists( 'twentytwentyfour_pattern_categories' ) ) :
	/**
	 * Register pattern categories
	 *
	 * @since Twenty Twenty-Four 1.0
	 * @return void
	 */
	function twentytwentyfour_pattern_categories() {

		register_block_pattern_category(
			'page',
			array(
				'label'       => _x( 'Pages', 'Block pattern category' ),
				'description' => __( 'A collection of full page layouts.' ),
			)
		);
	}
endif;

add_action( 'init', 'twentytwentyfour_pattern_categories' );
