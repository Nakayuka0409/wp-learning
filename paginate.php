<?php if (paginate_links()) : ?>
    <div class="pager">
        <ul class="pagerList">
        <?php
        echo paginate_links(
            array(
                'end_size' => 1,
                'mid_size' => 2,
                'prev_next' => true,
                'next_next' => true,
                'prev_text' => '前へ',
                'next_text' => '次へ',
            )
        );
        ?>
        </ul>
    </div>
<?php endif; ?>