<?php get_header();

$term = get_term_by( 'slug', get_query_var( 'term' ), 'plan_cat' );
if ( is_wp_error( $term ) ) {
	$h3 = 'キッチン';
	$term_slug = 'kitchen';
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
	'posts_per_page' => 10,		/* 最大表示数 */
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


<div id="wrap">
	<h2 class="main_tit"><?php echo $h3; ?><span class=migiyose><?php echo gr_get_posts_count(); ?>件</span></h2>

		<section id="top_plan" class="clearfix">

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


				<?php if (have_posts()) : ?>
				<? $i = 0;
				$x = 0; ?>

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

			<?php else : ?>
			<p style="margin-left:10px;">現在登録されておりません。</p>
			<?php endif; ?>
			<?php wp_reset_query(); /* ループ終わり */ ?>


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

			<!-- ==========　▽ タツケンホームのリフォーム安心パックが選ばれる理由　▽ ========== -->
			<div id="reform201502">
			<div class="points">
				<h3><img src="/wp-content/themes/reform/page_image/kitchen/ttl_5points.jpg" width="730" height="134" alt="タツケンホームのリフォーム安心パックが選ばれる理由" /></h3>
				<ul>
					<li class="pont1"><span class="tit">その1：即日対応</span><span class="description">地域密着型の強みを活かし、お問い合わせ頂けましたら、即日ご返答致します。</span></li>
					<li class="pont2"><span class="tit">その2：地域最安値</span><span class="description">お客様に良いものを、よりお求め易くご提供できるように、努力を重ねております。</span></li>
					<li class="pont3"><span class="tit">その3：責任施工</span><span class="description">丸投げ工事は一切行いません！当社専属の職人と共に責任を持って家づくりに励んでいます。</span></li>
					<li class="pont4"><span class="tit">その4：押売勧誘一切なし</span><span class="description">売込みや、電話で営業をかけたりする様な事は一切ありません。ご指名頂けるよう努力致します。</span></li>
				</ul>
				</div>
			</div>
			<!-- ==========　△ タツケンホームのリフォーム安心パックが選ばれる理由　△ ========== -->


		</section><!-- //end #top_plan -->
			<?php gr_about_banner(); ?>
			<?php gr_contacts_banner(); ?>
			<?php get_footer(); ?>
