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
1. 現在表示されているsubtitleやbootstrapなどの表示を修正する。
   前回記述した`<?php the_title(); ?>`の下に"subtitle"なるタブがあったが、WordPressにサブタイトルはないので`<?php the_content(); ?>`とし本文を表示させるようにしたい。</br>
   また、投稿者が直記述で`<a href="#">Start Bootstrap</a>`となっている箇所を`<?php the_author(); ?>`とし投稿者を表示されるようにする</br>
   ```
    <?php the_post(); ?>
        <div class="post-preview">
          <a href="post.html">
            <h2 class="post-title">
              <?php the_title(); ?>
            </h2>
            <h3 class="post-subtitle">
              <?php the_content(); ?>      //追記
            </h3>
          </a>
          <p class="post-meta">Posted by
            <?php the_author(); ?>      //追記
            on <?php the_time("Y/m/d"); ?></p>
        </div>
        // 以下は略
   ```
   </br>
2. CSSの設定を行う。
   "index.php"の中に`<!-- Custom styles for this template -->`という部分がある。これはこのページのCSSをどこから読み込むか指定させるタグがある箇所。</br>
   現状だと`link href="css/clean-blog.min.css" rel="stylesheet"`となっている箇所を</br>
   とりあえずこのオリジナルテーマのパスである`link href="wp-content/themes/WP_TryOriginalTheme/css/clean-blog.min.css" rel="stylesheet"`とすると、用意されたCSSが正しく表示される。</br>
   しかし直接ファイルのパスを記述するのは良くないとされているためphpでテンプレートタグを呼び出す仕様にする。</br>
   `link href="<?php echo get_template_directory_uri(); ?>` とする。</br>
   下記は記載した箇所</br>
   ```
   <!-- Custom styles for this template -->
   <link href="<?php echo get_template_directory_uri(); ?>/css/clean-blog.min.css" rel="stylesheet"> // 追記箇所
   <?php wp_head(); ?>
   </head>
   ```
   </br>
## 第4回の内容
### ループを使って一覧を表示させる
1. 現状だと最新の投稿しか表示されていないので2件目、3件目も表示されるようにする
   前回より記載されている`<?php the_post(); ?>`という箇所を`<?php while (have_post()) : the_post(); ?>`に変更</br>
   次に直下の`<hr>`の下に`<?php endwhile; ?>`を記述する。</br>
   以下はその様子</br>
   ```
   <?php while (have_post()) : the_post(); ?>   //追記
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
          <hr>
        <?php endwhile; ?>     //追記
   ```
   わかりやすくするために`option + shift + F`をおして`<?php while (have_post()) : the_post(); ?> `から`<hr>`までをインデント&整形する。</br>
   </br>
2. ダミー記事を消す
   1.で追記した`<?php endwhile; ?>`より下の箇所を`<!-- Pager -->`の上のところまで削除</br>
3. 修正
