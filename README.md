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
1. boostrapより"Clean Blog"というフリーテーマをDL。のち解凍する。</br>
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

3. index.php内でその他のリンクを参照している箇所を差し替えていく。</br>
   2.のcssの位置を指定し直したようにその他jsやimgなどlinkで照している箇所などに`<?php echo get_template_directory_uri(); ?>`を挿入して正しく参照されるようにする。</br>
   </br>
  
## 第4回の内容
### ループを使って一覧を表示させる
1. 現状だと最新の投稿しか表示されていないので2件目、3件目も表示されるようにする。</br>
   前回より記載されている`<?php the_post(); ?>`という箇所を`<?php while (have_post()) : the_post(); ?>`に変更</br>
   次に直下の`<hr>`の下に`<?php endwhile; ?>`を記述する。</br>
   以下はその様子。</br>
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
2. ダミー記事を消す</br>
   1.で追記した`<?php endwhile; ?>`より下の箇所を`<!-- Pager -->`の上のところまで削除</br>
   </br>
3. 表示件数を確認し、本文の表示範囲を調整する。</br>
   3-1．[WordPressテーマユニットテストデータ](https://github.com/jawordpressorg/theme-test-data-ja/)をDLし、その中のXMLデータをワードプレスのツールのインポートから開く。</br>
   3−2．展開すると40数件の投稿されるので確認する。</br>
   3−3．現在本文表示を指定している`<?php the_content(); ?>`だと全文表示されるのでトップ画面としては好ましくない。そのため、`<?php the_excerpt(); ?>`に入れ替えて本文の一部表示するように指定する。</br>
   </br>
4. 現在表示されている投稿件数の次のページへのリンクを作る。</br>
   `<!-- Pager -->`直下の`<div class="clearfix">`の次に`<?php next_posts_link(); ?>`を記述する。</br>
   これにより**次のページへ**というリンクが追加される。</br>
   また、`<?php previous_posts_link(); ?>`と記述する事で**前のページへ**というリンクが追加される。</br>
   あるいは`<?php echo paginate_links(); ?>`とすれば**1 2 3...5 次へ**のような表示をさせる事ができる。
   以下のその様子</br>
   ```
     <!-- Pager -->
        <div class="clearfix">
        <!-- <?php previous_posts_link(); ?> -->
        <!-- <?php next_posts_link(); ?> -->
        <?php echo paginate_links(); ?>
          <!--もとのbootstrapのnextボタン <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a> -->
        </div>
   ```
   </br>
## 第5回の内容
### テンプレート改装で、投稿ページと固定ページを作ろう
1. 各投稿にリンクを付ける。</br>
   現状では各投稿に対してそのリンクが参照されていないため、前回ループを指定した`<?php while (have_posts()) : the_post(); ?>`の中のaタグ`<a href="post.html">`を`<a href="<?php the_permalink(); ?>">`に変更する。</br>
   これで個々の投稿のみ表示されるindexページへジャンプできるようになるがもちろんこれではよくない。</br>
   </br>
2. 正しく個別投稿ページへリンクさせるためにテンプレート階層を用いる。</br>
   [テンプレート階層](https://wpdocs.osdn.jp/%E3%83%86%E3%83%B3%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88%E9%9A%8E%E5%B1%A4/)を参照。</br>
   現在は**index.php**というファイルを使用してすべてを見ている状態。</br>
   wordpressは上記リンク内の[テンプレート階層図](https://unofficialtokyo.com/wordpress-template-hierarchy//)の左に近いphpを優先して使用する。
   ここで下の階層を参照して、各投稿ページを見れるようにする。</br>
   </br>
   2-1. 同ディレクトリ内に**single.php**というファイルを作成する。</br>
   ためしにここに何らかのhtmlを各投稿ページのリンクへ飛んだときこのsingle.phpの内容で表示される。また、このsingle.phpを削除したのち再度リンクへ飛ぶとindex.phpの内容で表示される。</br>
   これがWordPressのテンプレート階層の優先順位(図の左にある方が優先される)である。</br>
   </br>
   2-2. single.phpのテーマ元である"clean blog"(startbootstrap-clean-blog-gh-pages)のディレクトリの中にある”post.html"の内容をコピペする。</br>
   その後、最初にindex.phpでやった書き換えを行う。</br>
   ①`<html lang = en> → <html lang=ja>`</br>
   ②下記を削除
   ```
       <meta name="description" content="">
       <meta name="author" content="">
       <title>Clean Blog - Start Bootstrap Theme</title>
   ```  
   ③第3回の3のようにリンクや参照に`<?php echo get_template_directory_uri(); ?>`を挿入して正しく参照される
   ④head要素の最後に`<?php wp_head(); ?>`、body要素の最後に`<?php wp_footer(); ?>`を記述。
   ⑤index.phpと同様に`<?php while(have_posts()): the_post(); ?>`と`<?php endwhile; ?>`を記載。
   ⑥post-metaの中身だけをペースト
   ```
   index.php
   <p class="post-meta">Posted by
              <?php the_author(); ?>
              on <?php the_time('Y/m/d/g:ia'); ?></p>
          </div>
   ↓
   single.php
   <span class="meta">Posted by
              <?php the_author(); ?>
              on <?php the_time('Y/m/d/g:ia'); ?></span>
   ```
   </br>
## 第6回の内容
### functions.phpでサムネイル画像を表示しよう
1. オリジナルテーマディレクトリに**functions.php**という名前のファイルを作成</br>
   内容を下記のようにする。
   ```
   <?php
   function init_func(){ 
    add_theme_support('title-tag');        //タグに表示されるページタイトルを表示
    add_theme_support('post-thumnails');   //投稿確認画面の右のメニューにアイキャッチ画像の機能を追加
   }
   add_action('init','init_func');
   ```
   </br>
2. **single.php**に指定したサムネイルが表示されるように設定する。</br>
   いずれかの投稿に1.で追加したアイキャッチ画像機能で画像を指定。</br>
   今回は[3件目です。](http://localhost:8888/mamp_wordpress_handson/wp-admin/post.php?post=14&action=edit/)を指定。</br>
   **single.php**のheader要素の頭に次のように追記。
   ```
   <!-- Page Header -->
    <?php
    $id = get_post_thumbnail_id();
    $img = wp_get_attachment_image_src($id);
    ?>
    <header class="masthead" style="background-image: url('<?php echo $img[0]; ?>')">
    下記は略
    ```
   指定したページを確認し、指定したアイキャッチ画像が表示されていればOK。</br>
   </br>
## 第7回の内容
### 本文に入力欄を追加できるカスタムフィールドを使おう
概要：WordPressのカスタム3兄弟と呼ばれる**カスタム要素(カスタムフィールド、カスタムポストタイプ、カスタムタクソノミー)**がある。</br>
今回は**カスタムフィールド**を扱う。</br>
1. WordPressの新規投稿画面からカスタムフィールドを有効にする。</br>
   新規投稿画面の右上の3点メニューの中の"設定"→"パネル"→"カスタムフィールド"にチェックを入れる。</br>
   カスタムフィールドで仮に下記を追加。
   | 名前         | 値                |
   | ------------ | ----------------- |
   | 価格         | 1500              |
   | 発売日        | 2021年5月2日       |
   
   しかしこのままでは表示に反映されない。
   </br>
2. カスタムフィールドが表示されるようにsingle.phpを編集する。</br>
   2-1. 一旦、表示だけさせるためにdlタグ（定義の意味）を用いて直接記述する。
   ```    <!-- Post Content -->
    <article>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <?php the_content(); ?>

            <dl>
             <dt>価格</dt>
             <dd>1,500円</dd>
             <dt>発売日</dt>
             <dd>2021年5月2日</dd>
          </div>
   以下は略
   ```
   </br>
   2-2. 上記の記述を関数に置き換えて先程指定したカスタムフィールドを呼び出せるようにする。</br>
   次の関数を使用して書き換えていく。</br>
   `<?php $meta_values = get_post_meta($post_id, $key, $single); ?>`</br>
   詳細は下記を参照。</br>
   参照：[関数リファレンス"get_post_meta](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_post_meta/)</br>
   以下はその書き換えた様子</br>
   ```
   <dl>
    <dt>価格</dt>
    <?php
    $price = get_post_meta(get_the_ID(), '価格', true);
    ?>
    <dd><?php echo $price; ?>円</dd>
    
    <dt>発売日</dt>
    <?php
    $published = get_post_meta(get_the_ID(), '発売日', true);
    ?>
    <dd><?php echo $published; ?></dd>
   </dl>
   ```