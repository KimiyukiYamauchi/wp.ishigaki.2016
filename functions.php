<?php
/**
 * アイキャッチ画像を使用するようにする
 */
add_theme_support('post-thumbnails');

/**
 * カスタムメニュー機能を使用可能にする
 */
add_theme_support('menus');

/**
 * コメント投稿フォームから入力フィールドを削除する
 */
add_filter('comment_form_default_fields', 'my_comment_form_default_fields');
function my_comment_form_default_fields($args){
	//$args['author'] = '';	// 「名前」を削除
	//$args['email'] = '';	// 「メールアドレス」を削除
	$args['url'] = ''; 		// 「ウェブサイト」を削除
	return $args;
}

/**
 * head内にRSSのlink要素を出力する
 */
add_theme_support('automatic-feed-links');

/**
 * 本文から抜粋として切り出す文字数を指定
 */
add_filter('excerpt_mblength', 'my_excerpt_mblength');
function my_excerpt_mblength($length){
	return 50;
}

/**
 * 残りの部分がある旨の表示を変更
 */
add_filter('excerpt_more', 'my_excerpt_more');
function my_excerpt_more($more){
	return '[......]';
}
/**
 * rssフィードにアイキャッチ画像を追加
 */
function rss_post_thumbnail( $content) {
    global $post;
    if (has_post_thumbnail( $post->ID)) {
        $content = '<p>' . get_the_post_thumbnail($post->ID) .'</p>' . $content;
    }
    return $content;
}
add_filter( 'the_excerpt_rss',  'rss_post_thumbnail');
add_filter( 'the_content_feed', 'rss_post_thumbnail');

// RSS 2.0を停止
//remove_action('do_feed_rss2', 'do_feed_rss2', 10, 1);

/**
 * トップページのみ投稿数を3件に設定
 */
add_action('pre_get_posts', 'my_pre_get_posts');
function my_pre_get_posts($query){
	// 管理画面、メインクエリ以外には設定しない
	if(is_admin() || !$query->is_main_query()){
		return;
	}

	// メインクエリで、
	// トップページの場合
	if($query->is_home()){
		$query->set('posts_per_page', 3);
	}
}

/**
 * 管理画面用に独自のCSSを設定する
 */
add_action('admin_print_styles', 'print_admin_stylesheet');
/**
 * ログイン画面に独自のCSSを設定する
 */
add_action('login_head', 'print_admin_stylesheet');

function print_admin_stylesheet(){
	echo '<link href="' . get_template_directory_uri() . '/css/admin.css" type="text/css" rel="stylesheet" media="all" />' . PHP_EOL;
}

/**
 * 必ずビジュアルモードは表示されるように設定
 */
add_filter('wp_default_editor', 'my_wp_default_editor');
function my_wp_default_editor(){
	return 'tinymce';
}