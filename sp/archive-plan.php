<?php get_header(); ?>
<?php
get_header();

$args = array(
	'post_type' => 'plan', /* 投稿タイプを指定 */
	'paged' => $paged,		/* ページ番号を指定 */
	'posts_per_page' => 16,		/* 最大表示数 */
);
query_posts( $args );
?>

<div id="wrap">
	<h2 class="main_tit">水回りプラン<span class=migiyose><?php echo gr_get_posts_count(); ?>件</span></h2>

			<div id="plan">
				<h2 class="mainPack">
					<?php
					printf(
						'<img src="%1$s/page_image/plan/main_plan_sp.jpg" alt="水回り" height="auto" />',
						get_stylesheet_directory_uri()
					);
					?>
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





			<br clear="all">


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
								</div></div>
			<!-- ==========　△ タツケンホームのリフォーム安心パックが選ばれる理由　△ ========== -->



			</div><!--id="plan"-->


			<?php gr_about_banner(); ?>
			<?php gr_contacts_banner(); ?>
			<?php get_footer(); ?>
