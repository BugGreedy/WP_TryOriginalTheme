# WP_TryOriginalTheme
WordPressのオリジナルテーマの練習</br>

## 第1回の内容
### 最低限のテーマファイルを作成
1. */Applications/MAMP/htdocs/mamp_wordpress_handson/wp-content/themes*に**index.php**と**style.css**を作成。</br>
   両方とも中身は空白でよい。</br>
   </br>
2. **style.css**に下記の内容を記載。</br>
   ```
   /*
   Theme Name: WP_TryOriginalTheme
   Author: BugGreedy
   Version: 1.0
   Description: WordPressオリジナルテーマの検討
   */
   ```
   </br>
3. ブラウザをWordPressの管理画面で確認。新たに作ったディレクトリ名でテーマが追加されていればOK。
</br>

## 第2回の内容
### テンプレートタグを使おう①
1. boostrapより"Cleam Blog"というフリーテーマをDL。のち解凍する。</br>
   解凍されたファイルの中から"index.html"というファイル名を"index.php"にし、オリジナルテーマディレクトリ内の既存のindex.phpと置き換える。</br>
   </br>
2. 置き換えたindex.phpをVScodeで開く。</br>
   76行目付近にあるh2タグの内容をWordPressのtitleタグ(テンプレートタグ)に置き換える。</br>
   ```
   <h2 class="post-title">
     <?php the_title(); ?>
   </h2>
   ```
   テンプレートタグについては下記を参照</br>
   [WordPress Codex 日本語版/テンプレートタグ](https://wpdocs.osdn.jp/%E3%83%86%E3%83%B3%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88%E3%82%BF%E3%82%B0)</br>
   </br>
3. headタグの終わりにwpヘッドテンプレートを記入。</br>
   ```
   # 略
     <?php wp_head(); ?>
   </head>
   ```
   </br>
4. bodyタグの終わりにwpヘッドテンプレートを記入。</br>
   ```
   # 略
     <?php wp_footer(); ?>
   </body>
   ```
   </br>
5. 2.で記述したタイトルタグの付近にthe_timeテンプレートタグを挿入</br>
   ```
         <div class="post-preview">
          <a href="post.html">
            <h2 class="post-title">
              <?php the_title(); ?>
            </h2>
            <h3 class="post-subtitle">
              Problems look mighty small from 150 miles up
            </h3>
          </a>
          <p class="post-meta">Posted by
            <a href="#">Start Bootstrap</a>
            on <?php the_time("Y-n-j"); ?></p>
        </div>
   ```
   ※日付と時刻のパラメータ(上記記述内の"Y-n-j")に関しては下記を参照</br>
   [日付と時刻の書式](https://ja.wordpress.org/support/article/formatting-date-and-time/)</br>
</br>

## 第3回の内容
### テンプレートタグを使おう②
1. 前回記述した<?php the_title(); ?>の下に"subtitle"なるタブがあったが、WordPressにサブタイトルはないので<?php the_content(); ?>とし本文を表示させるようにしたい。</br>
   また、投稿者が直記述で<a href="#">Start Bootstrap</a>となっている箇所を<?php the_author(); ?>とし投稿者を表示されるようにする</br>
   ```
    <?php the_post(); ?>
        <div class="post-preview">
          <a href="post.html">
            <h2 class="post-title">
              <?php the_title(); ?>
            </h2>
            <h3 class="post-subtitle">
              <?php the_content(); ?> 
            </h3>
          </a>
          <p class="post-meta">Posted by
            <?php the_author(); ?>
            on <?php the_time("Y/m/d"); ?></p>
        </div>
        // 以下は略
   ```