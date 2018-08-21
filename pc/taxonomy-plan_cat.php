<?php get_header();

$term = get_term_by( 'slug', get_query_var( 'term' ), 'plan_cat' );
if ( is_wp_error( $term ) ) {
	$h3 = 'キッチン';
	$term_slug = 'soudan_kitchen';
} else {
	$h3 = esc_html( $term->name );
	$term_slug = $term->slug;

	//親ターム名取得
	$term_p = $term->parent;
	if($term_p){
		$term_p = get_term( $term_p,'plan_cat');
		$term_pname = $term_p->name;
	}

}
$args = array(
	'plan_cat' => $term->slug, 	/* カスタムタクソノミーを指定　*/
	'paged' => $paged,			/* ページ番号を指定 */
	'posts_per_page' => 16,		/* 最大表示数 */
);
query_posts( $args );
?>

<?php
$term = get_term_by( /* タームごとの表示用　*/
    'slug',
    get_query_var('term'),
    get_query_var('taxonomy')
);
?>

<!-- ======================コンテンツここから======================= -->
<div id="content" class="clearfix">

<!-- ======================右コンテンツここから======================= -->
<div class="c_right">

	<ul id="pankuzu" class="clearfix">
		<?php the_pankuzu_keni( ' &gt; ' ); ?>
		<li><a href="<?php echo gr_get_permalink( 'plan' ); ?>">リフォーム</a> &gt; </li>
		<li><?php echo $h3; ?></li>
	</ul>


			<div id="plan">
				<h2 id="page_main_image">
					<?php if(is_tax('plan_cat','kitchen')): ?>
						<h2 class="nosp sp_none"><img src="/wp-content/themes/reform/page_image/plan/ttl_kitchen.jpg" width="730" height="95" alt="キッチンリフォーム" /></h2>
						<div class="mainPack">
							<img src="/wp-content/themes/reform/page_image/plan/main_kitchen.jpg" alt="タツケンホームのリフォーム安心パック" width="730" height="auto" />
						</div>

					<?php elseif(is_tax('plan_cat','toilet')): ?>
						<h2 class="nosp sp_none"><img src="/wp-content/themes/reform/page_image/plan/ttl_toilet.jpg" width="730" height="95" alt="トイレリフォーム" /></h2>
						<div class="mainPack">
							<img src="/wp-content/themes/reform/page_image/plan/main_toilet.jpg" alt="タツケンホームのリフォーム安心パック" width="730" height="auto" />
						</div>

					<?php elseif(is_tax('plan_cat','senmen')): ?>
						<h2 class="nosp sp_none"><img src="/wp-content/themes/reform/page_image/plan/ttl_senmen.jpg" width="730" height="95" alt="洗面リフォーム" /></h2>
						<div class="mainPack">
							<img src="/wp-content/themes/reform/page_image/plan/main_senmen.jpg" alt="タツケンホームのリフォーム安心パック" width="730" height="auto" />
						</div>

					<?php elseif(is_tax('plan_cat','ohuro')): ?>
						<h2 class="nosp sp_none"><img src="/wp-content/themes/reform/page_image/plan/ttl_ohuro.jpg" width="730" height="95" alt="お風呂リフォーム" /></h2>
						<div class="mainPack">
							<img src="/wp-content/themes/reform/page_image/plan/main_ohuro.jpg" alt="タツケンホームのリフォーム安心パック" width="730" height="auto" />
						</div>
					<?php else: ?>

					<?php endif; ?>
				</h2>






				<?php while( have_posts() ) : the_post(); ?>

					<div class="box">
						<div class="pict">
							<?php if(post_custom('plan_mainimg')){
								echo gr_get_image(
									'plan_mainimg',
								array( 'width' => '200', 'alt' => esc_attr( get_the_title() ), 'title' => esc_attr( get_the_title() ) )
								);
							}else{
								echo '<img src="/wp-content/themes/reform/page_image/plan/noimage.gif" width="200" height="150" alt="画像なし" />';
							}
								?>
						</div><!-- //.pict -->

						<div class="text">
							<p class="bun_box">
								<div class="maker">
									<?php echo '' . post_custom('plan_maker'); ?>
								</div>

								<p class="data">
									<?php echo '' . post_custom('plan_name'); ?><br />
									<?php echo '' . post_custom('plan_spec'); ?>
								</p>

								<p class="teika">
									定価価格<br />
									<span><?php echo number_format(post_custom('plan_teika')); ?></span>円
								</p>

								<div class="itemmoney">
									<p>
										<span><?php echo number_format(post_custom('plan_itemmoney')); ?></span>円（税抜）
									</p>
								</div>

								<div id="burst-12">
									<p><?php echo '' . post_custom('plan_value'); ?><span>%<br />OFF</span></p>
								</div>
							</p>
						</div>
					</div>

				<?php $i++; endwhile; ?>


				<!--customer_navi-->
				<div class="customer_navi clearfix">
						<div class="customer_navi_left">
								<p class="customer_red"><?php echo gr_get_posts_count(); ?>件</p>
						</div>

						<div class="customer_navi_right">
							<?php if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi(); ?>
						</div>
				</div>
				<!--customer_navi-->


			</div><!-- //#plan -->


<!-- ======================問い合わせ　共通　ここから======================= -->
<?php gr_contact_banner(); ?>
<!-- ======================問い合わせ　共通　ここまで======================= -->

</div>

<!-- ======================右コンテンツここまで======================= -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
