<?php
get_header();

$args = array(
	'post_type' => 'seko', /* 投稿タイプを指定 */
	'paged' => $paged,		/* ページ番号を指定 */
	'posts_per_page' => 15,		/* 最大表示数 */
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

				<h2 id="page_main_image">
					<?php
					printf(
						'<img src="%1$s/page_image/case_construction_title.gif" alt="施工事例" width="730" height="100" />',
						get_stylesheet_directory_uri()
					);
					?>
				</h2>
				<p id="case_text01">弊社のリフォームの施工事例をご紹介します。<br />
					施工事例を元に、「こんな風にリフォームしたい」という具体的なご要望を持つことが、リフォームを成功させる秘訣です。<br />
					価格や工期、完成後の様子などを、参考としてご活用ください。</p>

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


				<div class="content_seko_detail">
				<?php
				$i = 0;
				$x = 0;
				while( have_posts() ) : the_post(); ?>
					<div class="content_seko_detail_box<?php if($i%3==0){ echo " clear_left"; $x++; } ?> heightLine-group<?php echo $x; ?>">
					<p class="im_box" style="overflow:hidden;"><a href="<?php the_permalink(); ?>"><?php

					if(post_custom('seko_after_image')){
						echo gr_get_image(
							'seko_after_image',
							array( 'width' => '214', 'alt' => esc_attr( get_the_title() ), 'title' => esc_attr( get_the_title() ) )
						);
					}else if(post_custom('seko_csv01')){
						echo '<img src="/wp-content/themes/reform/page_image/'. post_custom('seko_csv01') .'" width="214" alt="' . get_the_title() . '" />';
					}
						?></a></p>
					<a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#000;">
					<h3><?php
					echo post_custom('seko_city') . post_custom('seko_name'); ?></h3>
					</a>
					<p class="bun_box">
					<a href="<?php the_permalink(); ?>" style="text-decoration:none;">
					<?php

					echo '<strong>' . nl2br(post_custom('seko_price')) . '</strong>';
					if(post_custom('seko_newicon')){ ?><img src="/wp-content/themes/reform/page_image/new.gif" width="30" height="10" alt="NEW" /><? }
					if(post_custom('seko_price') || post_custom('seko_newicon')){
						echo "<br />";
					}
					 ?>
					</a>
					<a href="<?php the_permalink(); ?>" style="text-decoration:none; color:#000;">
					<?php if(post_custom('seko_duration')){ echo '(工期：' . post_custom('seko_duration') . ')<br />'; } ?>
					<?php if(get_the_title()){ the_title(); echo "<br />"; } ?>
					</a>
					<a href="<?php the_permalink(); ?>">>>詳しくはこちら</a></p>
					</div>
				<?php
				$i++;
				endwhile; ?>
				</div>

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
				<div id="staff_content_area">

					<!--↓↓↓ 各カテゴリへのリンク一覧 ↓↓↓-->
					<div id="staff_content_area_m" class="clearfix heightLineParent">
						<?php
						$terms = get_terms( 'seko_cat', array( 'orderby' => 'term_order', 'order' => 'ASC' ) );
						foreach ( $terms as $term ) :
						?>
						<!--↓↓↓ 施工事例のキッチンへのリンク ↓↓↓-->
						<div class="case_content_area">
							<p class="pic">
								<a href="<?php echo get_term_link( $term ); ?>" class="banner_alpha">
									<?php if( @file( get_stylesheet_directory_uri() . "/page_image/case_" . __( $term->slug ) . ".jpg" ) ) : ?>
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/page_image/case_<?php esc_attr_e( $term->slug ); ?>.jpg" alt="<?php esc_attr_e( $term->name ); ?>" width="222" height="68" />
									<?php endif; ?>
								</a>
							</p>
							<p class="case_text02"><?php esc_html_e( $term->name ); ?>の施工事例</p>
						</div>
						<!--↑↑↑ 施工事例のキッチンへのリンク ↑↑↑-->
						<?php
						endforeach;;
						?>
					</div>
					<!--↑↑↑ 各カテゴリへのリンク一覧 ↑↑↑-->

				</div>
				<!--staff_content_area-->

				<p id="case_content02">
					<?php
					printf(
						'<img src="%1$s/page_image/special/case2/title.gif" width="732" height="50" alt="増改築・大型リフォーム" />',
						get_stylesheet_directory_uri()
					);
					?>
				</p>

				<!--↓↓↓ 増改築・大型リフォーム ↓↓↓-->
				<div class="case_kodawari_content">
				<?php get_specials(); ?>
				</div>
				<!--↑↑↑ 増改築・大型リフォーム ↑↑↑-->

<!-- ======================問い合わせ　共通　ここから======================= -->
<?php gr_contact_banner(); ?>
<!-- ======================問い合わせ　共通　ここまで======================= -->

<!-- ======================右コンテンツここまで======================= --><!-- // c_right_right -->
</div><!-- // c_right -->

<!-- ======================右コンテンツここまで======================= -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
