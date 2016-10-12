<?php
if(have_posts()) :
    while(have_posts()) : the_post();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('news'); ?>>
    <div class="text">
        <div class="entryInfo">
            <div class="categories">
                <?php the_category(); ?>
            </div>
            <time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y年m月d日(l)'); ?></time>
        </div>
        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <?php the_excerpt(); ?>
        <p>[<a href="<?php the_permalink(); ?>">続きを読む</a>]</p>
    </div>
    <figure>
    <div class="image">
        <?php display_thumbnail(); ?>
    </div>
    </figure>
</article><!-- /.news -->

<?php
    endwhile;
else : // 記事がなかった場合
?>
    <?php if(is_search()) : // 検索ページの場合 ?>
        <p>検索結果はありませんでした</p>
    <?php else : // 以外のページの場合 ?>
        <p>記事はありません。</p>
    <?php endif; ?>
<?php
endif;
?>

<?php if(function_exists('wp_pagenavi')){wp_pagenavi();} ?>