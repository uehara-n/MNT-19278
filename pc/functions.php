<?php
add_action( 'add_admin_bar_menus', 'gr_add_admin_bar_menus' );
function gr_add_admin_bar_menus() {
/*
	remove_action( 'admin_bar_menu', 'wp_admin_bar_my_account_menu', 0 );
	remove_action( 'admin_bar_menu', 'wp_admin_bar_search_menu', 4 );
	remove_action( 'admin_bar_menu', 'wp_admin_bar_my_account_item', 7 );
*/
	// Site related.
	remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
	remove_action( 'admin_bar_menu', 'wp_admin_bar_my_sites_menu', 20 );
	remove_action( 'admin_bar_menu', 'wp_admin_bar_site_menu', 30 );
	remove_action( 'admin_bar_menu', 'wp_admin_bar_updates_menu', 40 );
	add_action( 'admin_bar_menu', 'gr_admin_bar_wp_menu', 10 );

	// Content related.
	if ( ! is_network_admin() && ! is_user_admin() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		remove_action( 'admin_bar_menu', 'wp_admin_bar_new_content_menu', 70 );
	}
	remove_action( 'admin_bar_menu', 'wp_admin_bar_edit_menu', 80 );

//	add_action( 'admin_bar_menu', 'wp_admin_bar_add_secondary_groups', 200 );
}
function gr_admin_bar_wp_menu( $wp_admin_bar ) {
	$wp_admin_bar->add_menu( array(
		'id'    => 'gr-logo',
		'title' => '<img class="gr-icon" src="'.get_stylesheet_directory_uri().'/images/gr-logo-t.png"/>',
		'href'  => 'http://www.gotta-ride.com',
		'meta'  => array(
			'title' => 'ゴッタライド',
		),
	) );
}
add_action( 'wp_head', 'gr_head' );
add_action( 'admin_head', 'gr_head' );
function gr_head() {
?>
<style type="text/css" media="screen">
#wpadminbar{background:#f5f5f5;border-bottom:1px solid #333;}
#wpadminbar .quicklinks a, #wpadminbar .quicklinks .ab-empty-item, #wpadminbar .shortlink-input, #wpadminbar { height: 40px; line-height: 40px; }
#wpadminbar #wp-admin-bar-gr-logo { background-color: #f5f5f5;}
#wpadminbar .gr-icon { vertical-align: middle; }
body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 40px;}
#wpadminbar .ab-top-secondary,
#wpadminbar .ab-top-menu > li:hover > .ab-item, #wpadminbar .ab-top-menu > li.hover > .ab-item, #wpadminbar .ab-top-menu > li > .ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu > li > .ab-item:focus, #wpadminbar #wp-admin-bar-gr-logo a:hover{background-color:transparent;background-image:none;color:#333;}
#screen-meta-links{display:none;}
#wpadminbar .ab-sub-wrapper, #wpadminbar ul, #wpadminbar ul li {background:#F5F5F5;}
#wpadminbar .quicklinks .ab-top-secondary > li > a, #wpadminbar .quicklinks .ab-top-secondary > li > .ab-empty-item,
#wpadminbar .quicklinks .ab-top-secondary > li {border-left: 1px solid #f5f5f5;}
#wpadminbar * {color: #333;text-shadow: 0 1px 0 #fff;}
</style>
<?php
}
add_filter( 'admin_footer_text', '__return_false' );
add_filter( 'update_footer', '__return_false', 9999 );
add_action( 'admin_notices', 'gr_update_nag', 0 );
function gr_update_nag() {
	if ( ! current_user_can( 'administrator' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}

// seko ページでは editor 非表示
add_action( 'admin_print_styles-post.php', 'bc_post_page_style' );
add_action( 'admin_print_styles-post-new.php', 'bc_post_page_style' );
function bc_post_page_style() {
	if ( in_array( $GLOBALS['current_screen']->post_type, array( 'seko', 'slide_img', 'leaflet','event' ,'voice','craftsman','staff','whatsnew','price' ) ) ) :
?>
<style type="text/css">
#postdivrich{display:none;}
#<?php global $current_screen; var_dump( $current_screen) ?>{}
</style>
<?php
	endif;
}
//スタッフの管理画面　順序順に並べる
function set_post_types_admin_order( $wp_query ) {
	if (is_admin()) {
		$post_type = $wp_query->query['post_type'];
			if ( $post_type == 'staff' ) {
			$wp_query->set('orderby', 'menu_order');
			$wp_query->set('order', 'ASC');
		}
	}
}
add_filter('pre_get_posts', 'set_post_types_admin_order');
// カスタムフィールド&カスタム投稿タイプの追加
function gr_register_terms( $terms, $taxonomy ) {
	foreach ( $terms as $key => $label ) {
		$keys = explode( '/', $key );
		if ( 1 < count( $keys ) ) {
			$key = $keys[1];
			$parent_id = get_term_by( 'slug', $keys[0], $taxonomy )->term_id;
		} else {
			$parent_id = 0;
		}
		if ( ! term_exists( $key, $taxonomy ) ) {
			wp_insert_term( $label, $taxonomy, array( 'slug' => $key, 'parent' => $parent_id ) );
		}
	}
}

add_action( 'init', 'bc_create_customs', 0 );
function bc_create_customs() {

	// 施工事例
    register_post_type( 'seko', array(
        'labels' => array(
            'name' => __( '施工事例' ),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_position' => 4,
        'supports' => array( 'title', 'editor','author' ),
    ) );

    register_taxonomy( 'seko_cat', 'seko', array(
         'label' => '施工事例カテゴリー',
         'hierarchical' => true,
    ) );

		$terms = array(
			'kitchen' => 'キッチン',
			'ohuro' => 'お風呂',
			'toilet' => 'トイレ',
			'gaiheki' => '外壁',
			'exterior' => '外構・エクステリア・庭',
			'living' => 'リビング・内装',
			'ogata' => '大規模リフォーム',
			'other' => 'その他',
	);
	gr_register_terms( $terms, 'seko_cat' );

	register_taxonomy( 'seko_staff', 'seko', array(
		'label' => 'スタッフカテゴリー',
    	'hierarchical' => true,
	) );

	// こだわり施工事例
	register_post_type( 'good_seko', array(
			'labels' => array(
		'name' => __( 'こだわり施工事例' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 5,
	'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'good_cat', 'good_seko', array(
			 'label' => 'こだわり施工事例カテゴリー',
	) );
	$terms = array(
		'good_kitchen' => 'キッチン',
		'good_ohuro' => 'お風呂',
	);
	gr_register_terms( $terms, 'good_cat' );

	// リフォームMenu
	register_post_type( 'reformmenu', array(
			'labels' => array(
		'name' => __( 'リフォームMenu' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 6,
	'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'reformmenu_cat', 'reformmenu', array(
			 'label' => 'リフォームMenuカテゴリー',
	 'hierarchical' => true,
	) );
	$terms = array(
		'reform_kitchen' => 'キッチン',
		'reform_ohuro' => 'お風呂',
		'reform_toilet' => 'トイレ',
		'reform_j2w' => '和室から洋室',
		'reform_kabegami' => '壁紙クロス',
		'reform_gaiheki' => '外壁',
		'reform_yane' => '屋根',
		'reform_kyuto' => '給湯',
		'reform_taishin' => '耐震',
		'reform_yuka' => '床',
	);
	gr_register_terms( $terms, 'reformmenu_cat' );

	// 価格表
	register_post_type( 'price', array(
			'labels' => array(
		'name' => __( '価格表' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 7,
	'supports' => array( 'title', 'editor','author' ),
	) );
	register_taxonomy( 'price_cat', 'price', array(
			 'label' => '価格表カテゴリー',
			 'hierarchical' => true,
	) );
	$terms = array(
		'price_kitchen' => 'キッチン',
		'price_ohuro' => 'お風呂',
		'price_ohuro/price_unitex' => 'ユニットバスの入替え',
		'price_ohuro/price_old2unit' => '在来工法のお風呂をユニットバスに',
		'price_ohuro/price_oldreform' => '在来工法のお風呂リフォーム',
		'price_toilet' => 'トイレ',
		'price_j2w' => '和室から洋室',
		'price_kabegami' => '壁紙クロス',
		'price_gaiheki' => '外壁リフォーム',
		'price_yane' => '屋根',
		'price_yanereform' => '屋根リフォーム',
		'price_yuka' => '床リフォーム',
		'price_kyuto' => '給湯器',
		'price_taishin' => '耐震リフォーム',
	);
	gr_register_terms( $terms, 'price_cat' );

	// 価格表(一覧)
	register_post_type( 'maker', array(
			'labels' => array(
		'name' => __( '価格表 一覧' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 8,
		'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'maker_cat', 'maker', array(
			 'label' => '価格表 一覧カテゴリー',
					 'hierarchical' => true,
	) );
	$terms = array(//ここにカテゴリー
	);
	gr_register_terms( $terms, 'maker_cat' );


	// よくあるご相談
	register_post_type( 'soudan', array(
			'labels' => array(
		'name' => __( 'よくあるご相談' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 9,
		'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'soudan_cat', 'soudan', array(
			 'label' => 'よくあるご相談カテゴリー',
			 'hierarchical' => true,
	) );
	$terms = array(
		'soudan_kitchen' => 'キッチン',
		'soudan_ohuro' => 'お風呂',
		'soudan_toilet' => 'トイレ',
		'soudan_j2w' => '和室から洋室',
		'soudan_kabegami' => '壁紙クロス',
		'soudan_yuka' => '床リフォーム',
	);
	gr_register_terms( $terms, 'soudan_cat' );


	// 工事の流れ
	register_post_type( 'nagare', array(
			'labels' => array(
		'name' => __( '工事の流れ' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 9,
		'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'nagare_cat', 'nagare', array(
			 'label' => '工事の流れカテゴリー',
			 'hierarchical' => true,
	) );
	$terms = array(
		'nagare_kitchen' => 'キッチン',
		'nagare_ohuro' => 'お風呂',
		'nagare_toilet' => 'トイレ',
		'nagare_j2w' => '和室から洋室',
		'nagare_kabegami' => '壁紙クロス',
		'nagare_yuka' => '床リフォーム',
	);
	gr_register_terms( $terms, 'nagare_cat' );


	// 現場日記
	register_post_type( 'genbanikki', array(
			'labels' => array(
		'name' => __( '現場日記' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 10,
	'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'genba_cat', 'genbanikki', array(
			 'label' => '現場日記カテゴリー',
				     'hierarchical' => true,
	) );



	// お知らせ
	register_post_type( 'whatsnew', array(
			'labels' => array(
		'name' => __( 'お知らせ' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 11,
	'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'whatsnew_cat', 'whatsnew', array(
			 'label' => 'お知らせカテゴリー',
		     'hierarchical' => true,
	) );

	// イベント
	register_post_type( 'event', array(
			'labels' => array(
		'name' => __( 'イベント' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 12,
	'supports' => array( 'title', 'editor' ),
	) );
	register_taxonomy( 'event_cat', 'event', array(
			 'label' => 'イベントカテゴリー',
		     'hierarchical' => true,
	) );

	// スタッフ
	register_post_type( 'staff', array(
			'labels' => array(
		'name' => __( 'スタッフ' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 13,
	'supports' => array( 'title', 'editor','author','page-attributes' ),
	) );
	register_taxonomy( 'staff_cat', 'staff', array(
			 'label' => 'スタッフ部署カテゴリー',
			 'hierarchical' => true,
	) );

	// 職人
	register_post_type( 'craftsman', array(
			'labels' => array(
		'name' => __( '職人' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 14,
	'supports' => array( 'title', 'editor' ),
	) );

	// お客様の声
	register_post_type( 'voice', array(
			'labels' => array(
		'name' => __( 'お客様の声' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 15,
	'supports' => array( 'title', 'editor','author' ),
	) );
	register_taxonomy( 'voice_staff', 'voice', array(
		'label' => 'スタッフカテゴリー',
         	'hierarchical' => true,
	) );

	// TOPスライドショー画像
	register_post_type( 'slide_img', array(
			'labels' => array(
		'name' => __( 'TOPスライドショー画像' ),
		'singular_name' => __( 'TOPスライドショー画像')
			),
			'public' => true,
			'menu_position' => 16,
	'supports' => array( 'title', 'editor' ),
	) );

	// TOPテロップ(一言メッセージ)
	register_post_type( 'telop', array(
			'labels' => array(
		'name' => __( 'TOPテロップ' ),
		'singular_name' => __( 'TOPテロップ')
			),
			'public' => true,
			'menu_position' => 17,
	'supports' => array( 'title' ),
	) );

	// チラシ
	register_post_type( 'leaflet', array(
			'labels' => array(
		'name' => __( 'チラシ' ),
		'singular_name' => __( 'チラシ')
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 18,
	'supports' => array( 'title', 'editor' ),
	) );


		// スタッフブログ
	register_post_type( 'staffblog', array(
			'labels' => array(
		'name' => __( 'スタッフブログ' ),
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 19,
	'supports' => array( 'title', 'editor' ),
	) );

	//プラン
	register_post_type('plan',array(
				'labels' => array(
					'name' => ('プラン'),
				),
				'public' => true,
				'has_archive' => true,
				'menu_position' => 20,
				'supports' => array('title','author'),

			) );
			register_taxonomy( 'plan_cat0', 'plan', array(
				'label' => 'プランカテゴリー',
		         	'hierarchical' => true,
			) );

}

//// hooks
add_filter( 'wp_list_categories', 'gr_list_categories', 10, 2 );
function gr_list_categories( $output, $args ) {
	return preg_replace( '@</a>\s*\((\d+)\)@', ' ($1)</a>', $output );
}

add_action( 'pre_get_posts', 'gr_pre_get_posts' );
function gr_pre_get_posts( $query ) {
	if ( is_admin() ) {
		if ( in_array( $query->get( 'post_type' ), array( 'seko', 'staff' ) ) ) {
			$query->set( 'posts_per_page', -1 );
		}
		return;
	}
/*
	if ( is_post_type_archive() ) {
		if ( 'seko' == get_query_var( 'post_type' ) ) {
			$query->tax_query[] = array(
				'taxonomy' =>	'seko_cat',
				'term'     => 'kitchen',
				'field'    => 'slug',
			);
		}
	}
*/
}

function gr_adjacent_post_join( $join, $in_same_cat, $excluded_categories ) {
	if ( false && $in_same_cat ) {
		global $post, $wpdb;

		$taxonomy  = $post->post_type . '_cat';
		$terms     = implode( ',', wp_get_object_terms( $post->ID, $taxonomy, array('fields' => 'ids') ) );
		$join      = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
		$join     .= $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id IN ($terms)", $taxonomy );
	}

	return $join;
}

//// functions
function gr_title() {
	global $page, $paged;

	wp_title( '|', true, 'right' );
	bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && is_front_page() )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf(  '%sページ', max( $paged, $page ) );
}

function gr_description() {
	$desc = get_option( 'gr_description' );

	if ( is_front_page() || ! $desc ) {
		bloginfo( 'description' );
	} else {
		$title = str_replace( '|', '', wp_title( '|', false ) );
		echo str_replace( '%title%', $title, get_option( 'gr_description' ) );
	}
}

function gr_get_posts_count() {
	global $wp_query;
	return get_query_var( 'posts_per_page' ) ? $wp_query->found_posts : $wp_query->post_count;
}

function gr_get_pagename() {
	$pagename = '';

	if ( is_page() ) {
		/*
		$obj = get_queried_object();
		if ( 14 == $obj->post_parent )
			$pagename = 'business';
		else
		*/
			$pagename = get_query_var( 'pagename' );
	} elseif( ! $pagename = get_query_var( 'post_type' ) ) {
		//
	}

	return $pagename;
}

define( 'GR_IMAGES', get_stylesheet_directory_uri() . '/images/' );
function gr_img( $file, $echo = true ) {
	$img = esc_attr( GR_IMAGES . $file );

	if ( $echo )
		echo $img;
	else
		return $img;
}

function gr_get_post( $post_name ) {
	global $wpdb;
	$null = $_post = null;

	if ( ! $_post = wp_cache_get( $post_name, 'posts' ) ) {
		$_post = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_name = %s LIMIT 1", $post_name ) );
		if ( ! $_post )
			return $null;
		_get_post_ancestors($_post);
		$_post = sanitize_post( $_post, 'raw' );
		wp_cache_add( $post_name, $_post, 'posts' );
	}

	return $_post;
}

function gr_get_permalink( $name, $taxonomy = '' ) {
	$link = false;

	if ( false && term_exists( $name, $taxnomy ) ) {
		$link = get_term_link( $name );
	} else if ( post_type_exists( $name ) ) {
		$link = get_post_type_archive_link( $name );
	} else {
		$_post = gr_get_post( $name );
		if ( $_post )
			$link = get_permalink( $_post );
	}

	return $link;
}

function gr_image_id( $key ) {
    $imagefield = post_custom( $key );
    return  preg_replace('/(\[)([0-9]+)(\])(http.+)?/', '$2', $imagefield );
}

function gr_get_image( $key, $att = '' ) {
	$id = gr_image_id( $key );

	if ( is_numeric( $id ) ) {
		if ( isset( $att['size'] ) ) {
			$size = $att['size'];
			unset( $att['size'] );
		}
		if ( isset( $att['width'] ) ) {
			$size = array( $att['width'], 99999 );
			unset( $att['width'] );
		}
		return wp_get_attachment_image( $id, $size, false, $att );
	}

	if ( $id ) {
		/* ファイル存在チェック
		 * $id = /images/seko/289-2-t.jpg のようなパスでここに渡ってくるので
		 * get_stylesheet_directory_uri()のようなhttpで絶対パスを指定せず
		 * dirname(__FILE__)でチェック
		 */
		if( file_exists( dirname(__FILE__) . "$id" ) ) {
			return sprintf(
				'<img src="%1$s%2$s"%3$s%4$s%5$s />',
				get_stylesheet_directory_uri(),
				$id,
				( $att['width' ] ? ' width="' .$att['width' ].'"' : '' ),
				( $att['height'] ? ' height="'.$att['height'].'"' : '' ),
				( $att['alt'   ] ? ' alt="'   .$att['alt'   ].'"' : '' )
			);
		}
	}

	return '';
}
function gr_get_image_src( $key ) {
	$id = gr_image_id( $key );
	$src = '';

	if ( is_numeric( $id ) ) {
		@list( $src, $width, $height ) = wp_get_attachment_image_src( $id, $size, false );
	} else if ( $id ) {
		$src = get_stylesheet_directory_uri() . $id;
	}
	return $src;
}

function gr_contact_banner() {
?>

<div class="content_kaiyu">
<h3><img src="/wp-content/themes/reform/images/common/kaiyu_title.gif" width="342" height="26" alt="タツケンホームってどんな会社？" title="タツケンホームってどんな会社？" /></h3>
<ul>
	<li><a href="/company/" title="会社案内"><img src="/wp-content/themes/reform/images/common/btn_k_company_rollout.jpg" width="230" height="190" alt="会社案内" /></a></li>
	<li><a href="/staff/" title="スタッフ紹介"><img src="/wp-content/themes/reform/images/common/btn_k_staff_rollout.jpg" width="230" height="190" alt="スタッフ紹介" /></a></li>
	<li><a href="/voice/" title="お客様の声"><img src="/wp-content/themes/reform/images/common/btn_k_voice_rollout.jpg" width="230" height="190" alt="お客様の声" /></a></li>
	<li><a href="/company/#message" title="代表あいさつ"><img src="/wp-content/themes/reform/images/common/btn_k_aisatsu_rollout.jpg" width="230" height="190" alt="代表あいさつ" /></a></li>
	<li><a href="/seko/" title="施工事例"><img src="/wp-content/themes/reform/images/common/btn_k_seko_rollout.jpg" width="230" height="190" alt="施工事例" /></a></li>
	<li><a href="/genbanikki/" title="現場日記"><img src="/wp-content/themes/reform/images/common/btn_k_genba_rollout.jpg" width="230" height="190" alt="現場日記" /></a></li>
</ul>
</div>

	<!-- ======================問合わせテーブルここから======================= -->
<div class="inquiry_table_top">
<span class="btn"><a href="<?php echo site_url(); ?>/contact/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/top_table_mail_rollout.jpg" width="192" height="68" /></a></span></div>
	<!-- ======================問合わせテーブルここまで======================= -->

<?php
}

if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
				'name' => 'sidebar',
				'before_widget' => '',
				'after_widget' => '</ul>',
				'before_title' => '<p class="pic">',
				'after_title' => '</p><ul class="page_left_menu">',
	) );
}

//// enqueue
add_action( 'wp_print_styles', 'gr_print_styles' );
function gr_print_styles() {
	if( ! is_admin() ) {
		if ( is_front_page() ) {
			wp_enqueue_style( 'gr_orbit'  , get_stylesheet_directory_uri() . '/common/css/orbit.css' );
		}
		wp_enqueue_style( 'gr_shadowbox', get_stylesheet_directory_uri() . '/common/css/shadowbox.css' );
		wp_enqueue_style( 'gr_common'   , get_stylesheet_directory_uri() . '/css/common.css' );
	}
}

add_action( 'wp_enqueue_scripts', 'gr_enqueue_scripts' );
function gr_enqueue_scripts() {
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

	if ( ! is_admin() ) {
		wp_enqueue_script( 'jquery'	);//		, get_stylesheet_directory_uri() . '/common/js/jquery-1.5.1.min.js'			, array(		  ), false, true );
		if ( is_front_page() ) {
			wp_enqueue_script( 'gr_orbit'		, get_stylesheet_directory_uri() . '/common/js/jquery.orbit-1.2.3.min.js'	, array( 'jquery' ), false, true );
		}
		wp_enqueue_script( 'gr_rollover'	, get_stylesheet_directory_uri() . '/common/js/rollover2.js'				, array( 'jquery' ), false, true );
		wp_enqueue_script( 'gr_scroll'		, get_stylesheet_directory_uri() . '/common/js/smoothScroll.js'				, array( 'jquery' ), false, true );
		wp_enqueue_script( 'gr_shadowbox'	, get_stylesheet_directory_uri() . '/common/js/shadowbox.js'				, array( 'jquery' ), false, true );
		wp_enqueue_script( 'gr_index'		  , get_stylesheet_directory_uri() . '/common/js/index.js'					, array( 'jquery', 'gr_shadowbox' ), false, true );
	}
}

//// admin

//add_action( 'admin_print_scripts-options-general.php', 'gr_options_general' );
add_action( 'admin_footer-options-general.php', 'gr_options_general' );
function gr_options_general() {
?>
<script type="text/javascript">
//<![CDATA[
(function($) {
	if($('body.options-general-php').length) {
		$('#blogdescription').parent().parent().before( $('#gr_companyname' ).parent().parent() );
		$('#blogdescription').parent().parent()
			.after( $('#gr_author' ).parent().parent() )
			.after( $('#gr_keywords' ).parent().parent() )
			.after( $('#gr_description' ).parent().parent() );
	}
})(jQuery);
//]]>
</script>
<?php
}

class GR_Admin {
	static private $options = NULL;

	public function GR_Admin() {
		$this->__construct;
	}

	public function __construct() {
		$this->options = array(
			array( 'id' => 'companyname', 'label' => '会社名'		     , 'desc' => '著作権表示用などに使用する会社名です。' ),
			array( 'id' => 'author'		, 'label' => '作成者'		     , 'desc' => 'サイトの作成者情報です。' ),
			array( 'id' => 'description', 'label' => 'ディスクリプション', 'desc' => '下層ページ用description' ),
			array( 'id' => 'keywords'	, 'label' => 'キーワード'	     , 'desc' => '半角コンマ（,）で区切って複数指定できます。' ),
		);
		add_action( 'admin_init'			, array( &$this, 'add_settings_fields' 		) );
		add_filter( 'whitelist_options'		, array( &$this, 'whitelist_options' 		) );
	}
	public function whitelist_options( $whitelist_options ) {
		foreach ( (array) $this->options as $option ) {
			$whitelist_options['general'][] = 'gr_' . $option['id'];
		}

		return $whitelist_options;
	}
	public function add_settings_fields() {
		foreach ( (array) $this->options as $key => $option ) {
			add_settings_field(
				$key+1, $option['label'], array( &$this, 'print_settings_field' ), 'general', 'default',
				array(
					'label_for' 	=> 'gr_' . $option['id'],
					'description' 	=> $option['desc'],
				)
			);
		}
	}
	public function print_settings_field( $args ) {
		printf(
			'<input name="%1$s" type="text" id="%1$s" value="%2$s" class="regular-text" />',
			esc_attr( $args['label_for'] ),
			esc_attr( get_option( $args['label_for'] ) )
		);
		if ( ! empty( $args['description'] ) )
			printf(
				'<span class="description">%1$s</span>',
				esc_html( $args['description'] )
			);
	}
}

new GR_Admin;

/***************************************/

/**
 * 管理画面でのフォーカスハイライト
 */
function focus_highlight() {
	?>
		<style type="text/css">
		input:focus,textarea:focus{
			background-color: #dee;
		}
	</style>
		<?php
}

add_action( 'admin_head', 'focus_highlight' );

/**
 * 投稿での改行
 * [br] または [br num="x"] x は数字を入れる
 */
function sc_brs_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
					'num' => '5',
					), $atts ));
	$out = "";
	for ($i=0;$i<$num;$i++) {
		$out .= "<br />";
	}
	return $out;
}

add_shortcode( 'br', 'sc_brs_func' );

//---------------------------------------------------------------------------
//\r\nの文字列の無効化
//---------------------------------------------------------------------------

add_filter('post_custom', 'fix_gallery_output');

function fix_gallery_output( $output ){
  $output = str_replace('rn', '', $output );
  return $output;
}


// echo fix_gallery_output(file_get_contents(__FILE__));

//---------------------------------------------------------------------------
//パンくず
//---------------------------------------------------------------------------

function the_pankuzu_keni( $separator = '　→　', $multiple_separator = '　|　' )
{
	global $wp_query;

	echo("<li><a href=\""); bloginfo('url'); echo("\">HOME</a>$separator</li>" );

	$queried_object = $wp_query->get_queried_object();

	if( is_page() )
	{
		//ページ
		if( $queried_object->post_parent )
		{
			echo( get_page_parents_keni( $queried_object->post_parent, $separator ) );
		}
		echo '<li>'; the_title(); echo '</li>';
	}
	else if( is_archive() )
	{
		if( is_post_type_archive() )
		{
			echo '<li>'; post_type_archive_title(); echo '</li>';
		}
		else if( is_category() )
		{
			//カテゴリアーカイブ
			if( $queried_object->category_parent )
			{
				echo get_category_parents( $queried_object->category_parent, 1, $separator );
			}
			echo '<li>'; single_cat_title(); echo '</li>';
		}
		else if( is_day() )
		{
			echo '<li>'; printf( __('Archive List for %s','keni'), get_the_time(__('F j, Y','keni'))); echo '</li>';
		}
		else if( is_month() )
		{
			echo '<li>'; printf( __('Archive List for %s','keni'), get_the_time(__('F Y','keni'))); echo '</li>';
		}
		else if( is_year() )
		{
			echo '<li>'; printf( __('Archive List for %s','keni'), get_the_time(__('Y','keni'))); echo '</li>';
		}
		else if( is_author() )
		{
			echo '<li>'; _e('Archive List for authors','keni'); echo '</li>';
		}
		else if(isset($_GET['paged']) && !empty($_GET['paged']))
		{
			echo '<li>'; _e('Archive List for blog','keni'); echo '</li>';
		}
		else if( is_tag() )
		{
			//タグ
			echo '<li>'; printf( __('Tag List for %s','keni'), single_tag_title('',0)); echo '</li>';
		}
	}
	else if( is_single() )
	{
		$obj = get_post_type_object( $queried_object->post_type );
		if ( $obj->has_archive ) {
			printf(
				'<li><a href="%1$s">%2$s</a>%3$s</li>',
				get_post_type_archive_link( $obj->name ),
				apply_filters( 'post_type_archive_title', $obj->labels->name ),
				$separator
			);
		} else {
			//シングル
			echo '<li>'; the_category_keni( $separator, 'multiple', false, $multiple_separator ); echo '</li>';
			echo( $separator );
		}
		echo '<li>'; the_title(); echo '</li>';
	}
	else if( is_search() )
	{
		//検索
		echo '<li>'; printf( __('Search Result for %s','keni'), strip_tags(get_query_var('s'))); echo '</li>';
	}
	else
	{
		$request_value = "";
		foreach( $_REQUEST as $request_key => $request_value ){
			if( $request_key == 'sitemap' ){ $request_value = $request_key; break; }
		}

		if( $request_value == 'sitemap' )
		{
			echo '<li>'; _e('Sitemap','keni'); echo '</li>';
		}
		else
		{
			echo '<li>'; the_title(); echo '</li>';
		}
	}
}

function get_page_parents_keni( $page, $separator )
{
	$pankuzu = "";

	$post = get_post( $page );

	$pankuzu = '<li><a href="'. get_permalink( $post ) .'">' . $post->post_title . '</a>' . $separator . '</li>';

	if( $post->post_parent )
	{
		$pankuzu = get_page_parents_keni( $post->post_parent, $separator ) . $pankuzu;
	}

	return $pankuzu;
}

function the_category_keni($separator = '', $parents='', $post_id = false, $multiple_separator = '/') {
	echo get_the_category_list_keni($separator, $parents, $post_id, $multiple_separator);
}

function get_the_category_list_keni($separator = '', $parents='', $post_id = false, $multiple_separator = '/')
{
	global $wp_rewrite;
	$categories = get_the_category($post_id);
	if (empty($categories))
		return apply_filters('the_category', __('Uncategorized', 'keni'), $separator, $parents);

	$rel = ( is_object($wp_rewrite) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

	$thelist = '';
	if ( '' == $separator ) {
		$thelist .= '<ul class="post-categories">';
		foreach ( $categories as $category ) {
			$thelist .= "\n\t<li>";
			switch ( strtolower($parents) ) {
				case 'multiple':
					if ($category->parent)
						$thelist .= get_category_parents($category->parent, TRUE, $separator);
					$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'keni'), $category->name) . '" ' . $rel . '>' . $category->name.'</a></li>';
					break;
				case 'single':
					$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'keni'), $category->name) . '" ' . $rel . '>';
					if ($category->parent)
						$thelist .= get_category_parents($category->parent, FALSE);
					$thelist .= $category->name.'</a></li>';
					break;
				case '':
				default:
					$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'keni'), $category->name) . '" ' . $rel . '>' . $category->cat_name.'</a></li>';
			}
		}
		$thelist .= '</ul>';
	} else {
		$i = 0;
		foreach ( $categories as $category ) {
			if ( 0 < $i )
				$thelist .= $multiple_separator . ' ';
			switch ( strtolower($parents) ) {
				case 'multiple':
					if ( $category->parent )
						$thelist .= get_category_parents($category->parent, TRUE, $separator);
					$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'keni'), $category->name) . '" ' . $rel . '>' . $category->cat_name.'</a>';
					break;
				case 'single':
					$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'keni'), $category->name) . '" ' . $rel . '>';
					if ( $category->parent )
						$thelist .= get_category_parents($category->parent, FALSE);
					$thelist .= "$category->cat_name</a>";
					break;
				case '':
				default:
					$thelist .= '<a href="' . get_category_link($category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'keni'), $category->name) . '" ' . $rel . '>' . $category->name.'</a>';
			}
			++$i;
		}
	}
	return apply_filters('the_category', $thelist, $separator, $parents);
}
function get_specials(){
	include "specials.php";
}
function get_menutoi(){
	include "menutoi.php";
}
function get_menuohuro1(){
	include "menuohuro1.php";
}
function get_menuohuro2(){
	include "menuohuro2.php";
}

function get_menukitchen1(){
	include "menukitchen1.php";
}
function get_menukitchen2(){
	include "menukitchen2.php";
}

function get_menutoilet1(){
	include "menutoilet1.php";
}
function get_menutoilet2(){
	include "menutoilet2.php";
}

function get_menuyane1(){
	include "menuyane1.php";
}
function get_menuyane2(){
	include "menuyane2.php";
}

function get_menugaiheki1(){
	include "menugaiheki1.php";
}
function get_menugaiheki2(){
	include "menugaiheki2.php";
}

function get_menuyuka1(){
	include "menuyuka1.php";
}
function get_menuyuka2(){
	include "menuyuka2.php";
}

function get_menukabegami1(){
	include "menukabegami1.php";
}
function get_menukabegami2(){
	include "menukabegami2.php";
}

function get_menuj2w1(){
	include "menuj2w1.php";
}
function get_menuj2w2(){
	include "menuj2w2.php";
}

function get_menutaishin1(){
	include "menutaishin1.php";
}
function get_menutaishin2(){
	include "menutaishin2.php";
}

function get_menukyuto1(){
	include "menukyuto1.php";
}
function get_menukyuto2(){
	include "menukyuto2.php";
}

//ダッシュボードの記述▼

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
global $wp_meta_boxes;

wp_add_dashboard_widget('custom_help_widget', 'ゴッタライドからのお知らせ', 'dashboard_text');
}
function dashboard_text() {
echo '<iframe src="http://www.gotta-ride.com/cloud/news.html" height=200 width=100% scrolling=no>
この部分は iframe 対応のブラウザで見てください。
</iframe>';
}

function example_remove_dashboard_widgets() {
    global $wp_meta_boxes;
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // 現在の状況
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // 最近のコメント
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // 被リンク
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // プラグイン
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // クイック投稿
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // 最近の下書き
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPressブログ
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // WordPressフォーラム
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets');

//ダッシュボードの記述▲

//投稿画面から消す▼

function remove_post_metaboxes() {
    remove_meta_box('tagsdiv-post_tag', 'post', 'normal'); // タグ
}
add_action('admin_menu', 'remove_post_metaboxes');

//投稿画面から消す▲ /ログイン時メニューバー消す▼

add_filter('show_admin_bar', '__return_false');

//ログイン時メニューバー消す▲　/アップデートのお知らせを管理者のみに　▼
if (!current_user_can('edit_users')) {
  function wphidenag() {
    remove_action( 'admin_notices', 'update_nag');
  }
  add_action('admin_menu','wphidenag');
}

//アップデートのお知らせ▲

/**
 *
 * 最新記事のIDを取得
 * @return  Int ID
 *
 */
function get_the_latest_ID() {
    global $wpdb;
    $row = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC");
    return !empty( $row ) ? $row->ID : '0';
}
function the_latest_ID() {
    echo get_the_latest_ID();
}

/*ＩＤ取得*/

function get_gaiyobar(){

echo <<<BNR

BNR;

}

//リフォームメニュー　一覧のURL取得処理
function getReformListUrl($cat,$post_id){
	$terms = get_the_terms($post_id,'soudan_cat');
	foreach($terms as $term){
		if($term->slug === $cat){
		  $link = get_term_link((int)$term->term_id,'soudan_cat'). '#' . $post_id;
		  break;
		}
	}
	return $link;
}

//メール投稿　誰でも投稿可能に
function ke_another_author($user_id, $address) {
    return koushin; // 投稿はすべてこのユーザーに固定（作っておくこと）
}
add_filter('ktai_validate_address', 'ke_another_author', 10, 2);

//現場日記
function get_the_post_image_src($postid,$size,$order=0,$max=null) {
    $attachments = get_children(array('post_parent' => $postid, 'post_type' => 'attachment', 'post_mime_type' => 'image'));
    if ( is_array($attachments) ){
        foreach ($attachments as $key => $row) {
            $mo[$key]  = $row->menu_order;
            $aid[$key] = $row->ID;
        }
        array_multisort($mo, SORT_ASC,$aid,SORT_DESC,$attachments);
        $max = empty($max)? $order+1 :$max;
        for($i=$order;$i<$max;$i++){
            return wp_get_attachment_image_src( $attachments[$i]->ID, $size );
        }
    }
}

function get_the_post_image_id($post_id,$size){
	$attachments = get_children(array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image','posts_per_page' => 1 ));
	if(is_array($attachments)){
	        foreach ($attachments as $attachments) {
	            $imgL = wp_get_attachment_image_src( $attachments->ID, 'large' );
	            echo '<p><a href="' . $imgL[0] . '" rel="lightbox[genba]">' . wp_get_attachment_image( $attachments->ID, $size ) . '</a></p>';
	        }
	}
}
//clear feed cache
/*
function turn_off_feed_caching( $feed ) {
	$feed->enable_cache( false );
}
add_action( 'wp_feed_options', 'turn_off_feed_caching' );
*/
