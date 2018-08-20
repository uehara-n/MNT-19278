<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript">

<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/allpage.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/top.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/page.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/orbit.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/skin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/common/css/jquery.lightbox-0.5.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/thickbox.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/themes/reform/css/font_m.css" id="fontcs" />

<?php if(is_page( '2423' )): ?>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/reform/css/contact.css" />
<?php else: ?>
<?php endif; ?>


<link rel="shortcut icon" href="/wp-content/themes/reform/images/favicon.ico">
<link rel="icon" href="/wp-content/themes/reform/images/favicon.ico">
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/smoothScroll.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/rollover2.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/thickbox.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/heightLine.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/navi.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/top.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/jquery.orbit-1.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/reform/common/js/jquery.wpcf7.confirm.js"></script>
<?php if(is_page_template('form.php')){
	// フォームテンプレートの時、自動郵便番号スクリプト入れる
				?>
					<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
					<script type="text/javascript">
					$(function(){
					  $('#zip').keyup(function(event){
					    AjaxZip3.zip2addr(this,'','ken','address');
					  })
					})
					</script>
<?php } ?>
<link rel="shortcut icon" href="<?php echo site_url(); ?>/favicon.ico" />
<script type="text/javascript">
$(function(){
	$('#slider').orbit();
});
</script>
<script>
jQuery(function() {
    var topBtn = jQuery('#footerFloatingMenu');
    topBtn.hide();
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 200) { // 200pxで表示
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
});
</script>

<!--FB-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--FB-->

<!--タツケンホームアナリティクス-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39695794-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--タツケンホームアナリティクス-->

<?php wp_head(); ?>
</head>

<body>
<a name="top" id="top"></a>
<!-- ======================ヘッダーここから======================= -->
<div class="header">
<div class="header_topbox">
  <div class="bt_font">
	<h2><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/moji.jpg" width="55" height="11" alt="文字サイズ" style="margin-top:5px;"/></h2>
	<ul>
		<li id="font_s"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/bt_s.jpg" width="21" height="22" alt="小" /></li>
		<li id="font_m"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/bt_m_on.jpg" width="21" height="22" alt="中" /></li>
		<li id="font_l"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/bt_l.jpg" width="21" height="22" alt="大" /></li>
	</ul>
</div>
<h1 class="header_message"><span class="content_tenpo">姫路市、たつの市のリフォーム。キッチン、風呂、トイレ、増改築、外壁塗装をリフォームするなら、タツケンホームへ！</span></h1>
<ul class="bt_header">
	<li><a href="<?php echo site_url(); ?>/other/sitemap"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/header_sitemap.jpg" width="66" height="11" alt="サイトマップ" style="margin-top:5px;"/></a></li>
	<li><a href="<?php echo site_url(); ?>/other/privacy"><Img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/header_privacy.jpg" width="110" height="11" alt="プライバシーポリシー" style="margin-top:5px;"/></a></li>
</ul>
</div>
  <div class="header_box">
    <a href="<?php echo site_url(); ?>/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/header_logo.jpg" alt="タツケンホーム" width="315" height="67" class="header_logo" /></a>

   <div class="header_right">
    <img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/header_staff.jpg" alt="タツケンホーム" width="82" height="98" class="info_uketsuke" />
    <img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/header_info.jpg" alt="お電話の問い合わせ" width="285" height="69" class="info_tel"/>
    <a href="<?php echo site_url(); ?>/contact/"><span class="info_tel"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/header_bt_mail_rollout.jpg" alt="お問い合せ、無料お見積もり" width="192" height="68"/></span></a>
</div>
</div>
<!-- ======================グローバルナビここから======================= -->
<div class="globalnavi_box">
<ul class="globalnavi">
	<li><a href="<?php echo site_url(); ?>/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu01_rollout.gif" width="135" height="60" alt="ホーム" /></a></li>
    <li><a href="<?php echo site_url(); ?>/company/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu02_rollout.gif" width="136" height="60" alt="会社案内" /></a><br />
    <ul>
		<li><a href="<?php echo site_url(); ?>/company#message">代表あいさつ</a></li>
        <li><a href="<?php echo site_url(); ?>/company/">会社案内</a></li>
		<li><a href="<?php echo site_url(); ?>/staff">スタッフ紹介</a></li>
		<li><a href="<?php echo site_url(); ?>/voice/">お客様の声、インタビュー</a></li>
	</ul>
	</li>
    <li><a href="<?php echo site_url(); ?>/seko/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu03_rollout.gif" width="136" height="60" alt="施工事例" /></a><br>
       	<ul>
        <li><a href="/genbanikki/">現場日記</a></li>
        <li><a href="/seko/">施工事例一覧(<?php $args = array(
		'post_type' => 'seko', /* 投稿タイプを指定 */
		'paged' => $paged,		/* ページ番号を指定 */
		);
		query_posts( $args );
		 echo gr_get_posts_count();
		 wp_reset_query();
		?>件)</a></li>
                <?php wp_list_categories( array(
			'post_type' => 'seko',
			'taxonomy' => 'seko_cat',
			'title_li' => '',
			'use_desc_for_title' => '0',
			'depth' => '2',
			'show_count' => '1',
		)); ?>


		</ul></li>

		 <li><a href="<?php echo site_url(); ?>/special/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu04_rollout.gif" width="135" height="60" alt="増改築・大型リフォーム" /></a><br />
    <ul>
		<li><a href="<?php echo site_url(); ?>/special/case1">Case1.セカンドライフを楽しむ家!</a></li>

	</ul>
	</li>



	<li><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu05_rollout.gif" width="136" height="60" alt="水まわり" /><br />
		<ul>
		<li><a href="<?php echo site_url(); ?>/ohuro/">お風呂</a></li>
		<li><a href="<?php echo site_url(); ?>/kitchen/">キッチン</a></li>
		<li><a href="<?php echo site_url(); ?>/toilet/">トイレ</a></li>
		<li><a href="<?php echo site_url(); ?>/senmen/">洗面</a></li>
	</ul>
	</li>
	<li><a href="<?php echo site_url(); ?>/reformmenu/gaiheki/"><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu06_rollout.gif" width="136" height="60" alt="外壁・屋根" /></a></li>
	<li><img src="<?php echo site_url(); ?>/wp-content/themes/reform/images/common/gmenu07_rollout.gif" width="136" height="60" alt="その他" /><br />
	<ul>
		<li><a href="<?php echo site_url(); ?>/reformmenu/kyuto/">給湯器</a></li>
		<li><a href="<?php echo site_url(); ?>/reformmenu/ecocute/">エコキュート</a></li>
	</ul></li>
    <li></li>
</ul>
</div>
<!-- ======================グローバルナビここまで======================= -->
</div>
<!-- ======================ヘッダーここまで======================= -->
