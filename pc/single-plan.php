<?php get_header(); the_post(); ?>
<!-- ======================コンテンツここから======================= -->
<div id="content" class="clearfix">

<!-- ======================右コンテンツここから======================= -->
<div class="c_right">
		
				<ul id="pankuzu" class="clearfix">
					<?php the_pankuzu_keni( ' &gt; ' ); ?>
				</ul>
					
					<?php 
					remove_filter('the_content', 'wpautop');
					the_content();
					add_filter('the_content', 'wpautop');
					?>
					
<!-- ======================問い合わせ　共通　ここから======================= -->
<?php gr_contact_banner(); ?>
<!-- ======================問い合わせ　共通　ここまで======================= -->

<!-- ======================右コンテンツここまで======================= --><!-- // c_right_right -->
</div><!-- // c_right -->

<!-- ======================右コンテンツここまで======================= -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>