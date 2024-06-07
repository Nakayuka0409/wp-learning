<?php
function my_enqueue_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('bundle_js', get_template_directory_uri() . '/assets/js/bundle.js', array());
    wp_enqueue_style('my_styles', get_template_directory_uri() . '/assets/css/styles.css', array());
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

//ヘッダー、フッターのカスタムメニュー化
register_nav_menus(
    array(
        'place_global' => 'グローバル',
        'place_footer' => 'フッターナビ',
    )
);

//メイン画像上にテンプレートごとの文字列を表示
function get_main_title()
{
    if (is_singular('post')) :
        $category_obj = get_the_category();
        return $category_obj[0]->name;
    elseif (is_page()) :
        return get_the_title();
    elseif (is_category()) :
        return single_cat_title();
    elseif (is_search()) :
        return 'サイト内検索結果';
    elseif (is_404()) :
        return 'ページが見つかりません';
    endif;
}

//子ページ一覧の抽出条件
function get_child_pages($number = -1, $specified_id = null)
{
    if (isset($specified_id)) :
        $parent_id = $specified_id;
    else :
        $parent_id = get_the_ID();
    endif;
    $args = array(
        'posts_per_page' => $number,
        'post_type' => 'page',
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_parent' => $parent_id,
    );
    $child_pages = new WP_Query($args);
    return $child_pages;
}

//アイキャッチ画像を利用できるようにする
add_theme_support('post-thumbnails');

//トップページのメイン画像用の設定
add_image_size('top', 1077, 622, true);

//地域貢献活動一覧画像用のサイズ設定
add_image_size('contribution', 557, 280, true);

//トップページの地域貢献活動にて使用している画像用のサイズ設定
add_image_size('front-contribution', 255, 189, true);

//企業情報・店舗情報一覧画像用のサイズ設定
add_image_size('common', 465, 252, true);

//各ページのメイン画像用のサイズ設定
add_image_size('detail', 1100, 330, true);

//検索一覧画像用のサイズ設定
add_image_size('search', 168, 168, true);

//各テンプレートごとのメイン画像を表示
function get_main_image()
{
    global $post; // $post変数をグローバルに宣言
    if (is_page()) :
        return get_the_post_thumbnail($post->ID, 'detail');
    elseif (is_category('news') || is_singular('post')) :
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-news.jpg" />';
        elseif(is_search() || is_404() ) :
            return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-search.jpg" />';
    else :
        return '<img src="' . get_template_directory_uri() . '/assets/images/bg-page-dummy.png" />';
    endif;
}

//特定の記事を抽出する関数
function get_specific_posts($post_type, $taxonomy = null, $term = null, $number = -1) {
    $args = array(
        'post_type' => $post_type,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term,
            ),
        ),
        'posts_per_page' => $number,
    );
    $specific_posts = new WP_Query($args);
    return $specific_posts;
}

//抜粋文のデフォルト文字数を定義
function cms_excerpt_more() {
    return '...';
}
add_filter('excerpt_more', 'cms_excerpt_more');

function cms_excerpt_length() {
    return 80;
}
add_filter('excerpt_mblength', 'cms_excerpt_length');

//抜粋機能を固定ページに使えるように設定
add_post_type_support('page', 'excerpt');

//各抜粋文を適度な長さに調整
function get_flexible_excerpt($number) {
    $value = get_the_excerpt();
    $value = wp_trim_words($value, $number, '...');
    return $value;
}

//get_the_excerpt()で取得する文字列に改行タグを挿入
function apply_excerpt_br($value) {
    return nl2br($value);
}
add_filter('get_the_excerpt', 'apply_excerpt_br');