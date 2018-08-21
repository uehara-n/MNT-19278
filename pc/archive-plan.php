<?php
get_header();

$args = array(
	'post_type' => 'plan', /* 投稿タイプを指定 */
	'paged' => $paged,		/* ページ番号を指定 */
	'posts_per_page' => 16,		/* 最大表示数 */
);
query_posts( $args );
?>
<!-- ======================コンテンツここから======================= -->
<div id="content" class="clearfix">

<!-- ======================右コンテンツここから======================= -->
<div class="c_right">

				<ul id="pankuzu" class="clearfix">
					<?php the_pankuzu_keni( ' &gt; ' ); ?>
				</ul>

			<div id="plan">
				<h2 id="page_main_image">
					<?php
					printf(
						'<img src="%1$s/page_image/plan/main_plan.jpg" alt="水回り" width="730" height="auto" />',
						get_stylesheet_directory_uri()
					);
					?>
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

			</div><!--id="plan"-->

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




				<!--↓↓↓  ↓↓↓-->
				<!-- <div id="staff_content_area">

					<!--↓↓↓ 各カテゴリへのリンク一覧 ↓↓↓-->
					<!-- <div id="staff_content_area_m" class="clearfix heightLineParent">
						<?php
						// $terms = get_terms( 'seko_cat', array( 'orderby' => 'term_order', 'order' => 'ASC' ) );
						// foreach ( $terms as $term ) :
						?>
						<!--↓↓↓ 施工事例のキッチンへのリンク ↓↓↓-->
						<!-- <div class="case_content_area">
							<p class="pic">
								<a href="<?php //echo get_term_link( $term ); ?>" class="banner_alpha">
									<?php //if( @file( get_stylesheet_directory_uri() . "/page_image/case_" . __( $term->slug ) . ".jpg" ) ) : ?>
										<img src="<?php //echo get_stylesheet_directory_uri(); ?>/page_image/case_<?php //esc_attr_e( $term->slug ); ?>.jpg" alt="<?php //esc_attr_e( $term->name ); ?>" width="222" height="68" />
									<?php //endif; ?>
								</a>
							</p>
							<p class="case_text02"><?php //esc_html_e( $term->name ); ?>の施工事例</p>
						</div> -->
						<!--↑↑↑ 施工事例のキッチンへのリンク ↑↑↑-->
						<?php
						//endforeach;;
						?>
					<!-- </div> -->
					<!--↑↑↑ 各カテゴリへのリンク一覧 ↑↑↑-->

				<!-- </div> -->
				<!--staff_content_area-->



<!-- ======================問い合わせ　共通　ここから======================= -->
<?php gr_contact_banner(); ?>
<!-- ======================問い合わせ　共通　ここまで======================= -->


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

<!-- ======================右コンテンツここまで======================= --><!-- // c_right_right -->
</div><!-- // c_right -->

<!-- ======================右コンテンツここまで======================= -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
