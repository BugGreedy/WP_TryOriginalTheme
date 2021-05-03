# WP_TryOriginalTheme
WordPressのオリジナルテーマの練習</br>

## 第1回の内容
### 最低限のテーマファイルを作成
1. */Applications/MAMP/htdocs/mamp_wordpress_handson/wp-content/themes*に**index.php**と**style.css**を作成。</br>
   両方とも中身は空白でよい。</br>
   </br>
2. **style.css**に下記の内容を記載。</br>
   ```CSS
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
   ```PHP
   <h2 class="post-title">
     <?php the_title(); ?>
   </h2>
   ```
   テンプレートタグについては下記を参照</br>
   [WordPress Codex 日本語版/テンプレートタグ](https://wpdocs.osdn.jp/%E3%83%86%E3%83%B3%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88%E3%82%BF%E3%82%B0)</br>
   </br>
3. headタグの終わりにwpヘッドテンプレートを記入。</br>
   ```PHP
   # 略
     <?php wp_head(); ?>
   </head>
   ```
   </br>
4. bodyタグの終わりにwpヘッドテンプレートを記入。</br>
   ```PHP
   # 略
     <?php wp_footer(); ?>
   </body>
   ```
   </br>
5. 2.で記述したタイトルタグの付近にthe_timeテンプレートタグを挿入</br>
   ```PHP
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
   ```php
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
   ```php
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
   ```php
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
   ```php
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
   ```html
       <meta name="description" content="">
       <meta name="author" content="">
       <title>Clean Blog - Start Bootstrap Theme</title>
   ```  
   ③第3回の3のようにリンクや参照に`<?php echo get_template_directory_uri(); ?>`を挿入して正しく参照される</br>
   ④head要素の最後に`<?php wp_head(); ?>`、body要素の最後に`<?php wp_footer(); ?>`を記述。</br>
   ⑤index.phpと同様に`<?php while(have_posts()): the_post(); ?>`と`<?php endwhile; ?>`を記載。</br>
   ⑥post-metaの中身だけをペースト</br>
   ```php
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
   ```php
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
   今回は[3件目です。](http://localhost:8888/mamp_wordpress_handson/2021/04/30/3%e4%bb%b6%e7%9b%ae%e3%81%a7%e3%81%99%e3%80%82/)を指定。</br>
   **single.php**のheader要素の頭に次のように追記。
   ```php
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
   ```php
   <!-- Post Content -->
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
   2-2. 上記の記述を関数に置き換えて先程指定したカスタムフィールドを呼び出せるようにする。</br>
   次の関数を使用して書き換えていく。</br>
   `<?php $meta_values = get_post_meta($post_id, $key, $single); ?>`</br>
   詳細は下記を参照。</br>
   参照:[関数リファレンスget_post_meta](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_post_meta/)</br>
   以下はその書き換えた様子。
   ```php
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
   </br>

3. カスタムフィールドをより使いやすくする。</br>
   3-1. WordPressのプラグイン"Advanced Custom Fields"を検索してインストール。</br>
   ("acf"と検索しても出てくる。)</br>
   WordPressのダッシュボードメニューに"カスタムフィールド"という項目が増えるので、そちらから"価格"と"発売日"を追加。</br>
   3-2. "Advanced Custom Fields"(以下"acf")をインストールする事により特別なテンプレートタグが追加される。それが`the field`である。</br>
   single.phpを下記のように編集
   ```php
   <dl>
    <dt>価格</dt>
    <dd><?php the_field('価格'); ?>円</dd>
    
    <dt>発売日</dt>
    <dd><?php the_field('発売日'); ?></dd>
   </dl>
   ```
   3-3. また、"acf"によって`the field`の他に`get_field`というテンプレートタグも追加される。</br>
   `the field`はバリューをそのまま表示するだけだが、`get_field`はその加工が可能になる。</br>
   ただし`get_field`は値を取得するだけなので、表示させるには`echo get_field`という記述になる。</br>
   以下はその例
   ```php
   <dl>
    <dt>価格</dt>
    <dd><?php echo number_format(get_field('価格')); ?>円</dd>
    
    <dt>発売日</dt>
    <dd><?php the_field('発売日'); ?></dd>
   </dl>
   ```
   ※ `number_format`は数値に対して3桁ごとにカンマを入れてくれるphpの関数。</br>
   例：</br>
   ```php
   <dd><?php the_field('価格'); ?>円</dd>
   ↓
   2000円
   
   <dd><?php echo number_format(get_field('価格')); ?>円</dd>
   ↓
   2,000円
   ```
</br>

## 第8回の内容
### カスタム投稿(ポスト)タイプで投稿欄を増やそう
概要：WordPressには投稿内容をカテゴリーで分類できる。また、会社概要などは固定ページで設定するなどできる。ただし、例えば"商品情報"などだと一般的な"お知らせ"や"ブログ"などと異質でありカテゴリーや固定ページで表示する事が好ましくない。</br>
そこでカスタム投稿(ポスト)タイプで投稿欄を増やして、投稿内容にそぐわった表示ができるようにする。</br>
1. function.phpを編集する。
   ```php
   <?php
      function init_func(){ 
         dd_theme_support('title-tag');
         dd_theme_support('post-thumbnails');
         //  下記が追記箇所
         egister_post_type('item',[    //配列を使用する。※パーマリンクのURLの一部になる。つまりURLに使いたいワードを設定する。また、別記注意1を参照。
          'labels' => [
            'name' => '商品',
          ],
          'public' => true,            //このitemというポストタイプをメニューから使えるようにする。
          'has_archive' => true,       //一覧ページを持つか否か。
          'hierarchical' => false,     //継承→既存の追加物に対して親子関係を設定できる。子に設定した際はパーマリンクのURLは親に付随するかたちになる。例："Paython入門"の子"abc"の場合→"~/item/Python入門/abc/"となる。
            'supports' => [
               'title',
               'editor',
               'page-attributes'
            ],
          'menu_position' => 5,        //メニューの中のどこに表示するか決めることができる。1番上に表示する"1"以外は5の倍数で指定する。
          'menu_icon' => 'dashicons-cart'            //メニューのアイコンを設定できる。別記注意2を参照。
         );
      }
   ```
   上記の内容を追記すると、ワードプレスのダッシュボードのメニューバーに"商品"という項目が追加される。</br> 
   </br>
    **別記注意1**</br>
    WordPressにはデフォルトの投稿タイプが存在しており、これらのカテゴリ名は既存のものとしてここには記入できない。</br>
    以下がそのデフォルトの投稿タイプ名。</br>
   - 投稿 (投稿タイプ: 'post')
   - 固定ページ (投稿タイプ: 'page')
   - 添付ファイル (投稿タイプ: 'attachment')
   - リビジョン (投稿タイプ: 'revision')
   - ナビゲーションメニュー (投稿タイプ: 'nav_menu_item')
   </br>

   **別記注意2**</br>
   [ダッシュアイコン](https://developer.wordpress.org/resource/dashicons/#trash/)というアイコンを設定できる。この中から追加したカスタム投稿タイプにあったアイコンがないか探す。そのアイコンをクリックした後に表示されるテンプレート名を指定する事でこのアイコンを追加したカスタム投稿タイプにメニューバー上で表示する事ができる。</br>
   </br>
2. 追加されたメニューの
   今回は前回同様に'Python入門'という書籍を新規追加した。</br>
   追加すると同時にパーマリンクの設定が行われる。デフォルトだと`~/item(設定した配列名)/Python入門(新規追加した商品名)/`だが、パーマリンクは編集できる。</br>
   今回は`~/item/Python_basic/`に編集した。</br>
   ※補足：WordPressのバグというか仕様でパーマリンクを編集した際はダッシュボードのメニューの'設定'→'パーマリンク設定'→'変更を保存'をクリックする事で正しくパーマリンクの設定が行える。</br>
3. 新設した投稿タイプ'商品'にカスタムフィールドを設定する。
   前回作成したカスタムフィールドグループ'商品情報'を開く。</br>
   現在、商品情報のカスタムフィールドは**投稿タイプ/等しい/投稿**に設定されている。</br>
   これを**投稿タイプ/等しい/商品**に設定して"更新"をクリック。</br>
   これで投稿タイプ'商品'に'商品情報'のフィールドグループが追加される。</br>
</br>

## 第9回の内容
### カスタム投稿(ポスト)タイプのテンプレートファイルを作ろう
1. 商品のカスタム投稿タイプを作成したので、通常投稿の価格や発売日のカスタムフィールドの表示をなくす。</br>
   仮に表示をけすためにsingle.phpに下記の記述を追加
   ```php
   <?php if(!is_singular('post')): ?>   // ここと
     <dl>
      <dt>価格</dt>
      <dd><?php echo number_format(get_field('価格')); ?>円</dd>
      
      <dt>発売日</dt>
      <dd><?php the_field('発売日'); ?></dd>
     </dl>
   <?php endif; ?>   // ここを追記
   ```
   この記述によって通常の投稿には価格と発売日のカスタムフィールドの表示をなくす事ができる。</br>
   しかし、一般の投稿とカスタム投稿ではレイアウトが違ったりif構文を入れる事で内容が複雑化するおそれがある。</br>
   そのため、single.phpより優先されるカスタム投稿タイプに使われるテンプレートファイルを作成して対応させる。</br>
   </br>
2. カスタム投稿タイプ用のテンプレートファイルを作成する。</br>
   `single.php`をコピーして**single-item.php**という名前で複製する。これにより前回指定した"item"つまり"商品"のカスタム投稿タイプはこちらのテンプレートファイルを優先して使用されるようになる。</br>
   また、通常の投稿タイプで使用される`single.php`からは価格と発売日の表示をする部分を削除する。</br>
   </br>
3. 商品一覧ページを編集する。</br>
   まず、一覧ページを見るには追加したカスタム投稿タイプの後ろがないURLで表示する事ができる。例：今回の商品の場合は`~略/item/`</br>
   **注意**：`function.php`内で`'has_archive' => true,`になっていないと一覧が表示されない。</br>
   現在は一覧(archive)ページのテンプレートは作成していないため`index.php`が使用されている。一般的なarchiveファイルを当てるのは他の投稿タイプが存在する可能性を考慮してやめておきたい。そこで前回のカスタム投稿タイプ専用のテンプレートファイルを作成したように今回も専用のアーカイブテンプレートファイルを作成する。</br>
   `index.php`をコピーして**archive-item.php**として複製する。</br>
4. 一覧テンプレートファイルを編集する。</br>
   `archive-item.php`を下記のように編集。</br>
   ```php
   <!-- Page Header -->
   <header class="masthead" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Clean Blog</h1>  //  タイトルを"商品一覧"に変更
            <span class="subheading">A Blog Theme by Start Bootstrap</span> // サブタイトルは必要ないので削除
          </div>
        </div>
      </div>
    </div>
   </header>
   ```
   次に下記も編集。
   ```php
   <!-- Main Content -->
   <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php while (have_posts()) : the_post(); ?>
          <div class="post-preview">
          <a href="<?php the_permalink(); ?>">
              <h2 class="post-title">
                <?php the_title(); ?>
              </h2>
              <h3 class="post-subtitle">    //  excerpt(商品説明)欄を削除
                <?php the_excerpt(); ?>  
              </h3>                         //  ここまで削除
            </a>
            <p class="post-meta">Posted by      //  Posted by欄を削除
              <?php the_author(); ?>
              on <?php the_time('Y/m/d/g:ia'); ?></p> // ここまで削除
              // 下記を追加(single-item.phpテンプレート作成時と同様に金額を表示させる。)
              <p> <?php echo number_format(get_field('価格')); ?>円</p>  
          </div>
          <hr>
        <?php endwhile; ?>
        <!--  もとのダミーがあった場所(削除ずみ) -->
        <!-- Pager -->
        <div class="clearfix">
        <!-- <?php previous_posts_link(); ?> -->
        <!-- <?php next_posts_link(); ?> -->
        <?php echo paginate_links(); ?>
          <!--もとのbootstrapのnextボタン <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a> -->
        </div>
      </div>
    </div>
   </div> 
   ```
   これで"商品"投稿タイプの一覧ページのテンプレートができた。</br>
</br>

## 第10回の内容
### カスタム分類（タクソノミー）で、分類項目を追加しよう
概要：投稿には主に"カテゴリー"と"タグ"という分類タイプがあるが、これは増やす事が可能。</br>
これが**カスタム分類(タクソノミー)**である。
1. `function.php`を編集する。
   ```php
   <?php
   function init_func(){ 

           略

     register_taxonomy('item_category','item',[  // 以下を追記
       'labels' => [
         'name' => '商品カテゴリー'
       ],
       'hierarchical' => true,
     ]);
   }
   add_action('init','init_func');
   ```
   補足：ここでの`'hierarchical'`のような配列のオプション(引数)は[こちら](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_taxonomy/)を参照。</br>
   上記を追記する事で"商品"投稿タイプ(item)に"商品カテゴリー"というカスタム分類が追加された。</br>
   現状はカテゴリーのような使い勝手だが、`'hierarchical' => false,`にする事でタグのような使い方も可能。</br>
   簡単にいうと`'hierarchical'`を設定する事で親子関係ができるか、全て並列で扱うかを指定する事ができる。</br>
   また、`register_taxonomy('item_category','item',`の箇所の`'item'を'post'`にする事で通常の投稿に、また`'page'`とすることで固定ページに"商品カテゴリー"というカスタム分類を追加する事もできる。</br>
   </br>
   上記で追加したカスタム分類は、投稿を新規追加する際のエディタ(gutenbelg)のとき、右側のメニューに追加したカスタム分類が表示されない。</br>
   そこで下記を追記する事で上記の場所でも表示する事ができる。
   ```php
   register_taxonomy('item_category','item',[
      'labels' => [
        'name' => '商品カテゴリー'
      ],
      'hierarchical' => true,
      'show_in_rest' => true,
   ]);
   ```
   これで投稿の新規作成の右側のメニューに追加したカスタム分類を表示する事ができる。</br>
   </br>

2. カスタム分類(タクソノミー)のテンプレートファイルを作成する。</br>
   `index.php`をコピーして**item_category.php**として複製する。</br>
   前回同様にタイトルを編集し、日付など不要なものを削除。</br>
   </br>
   また、タクソノミーに関しては商品ページにどのカテゴリーか表示する必要がある場合がある。その際に使用できる関数がある。</br>
   `single-item.php`を下記のように編集。
   ```php
   <dl>
     <dt>カテゴリー</dt>
     <?php
     $terms = get_the_terms(get_the_ID(),'item_category');  //  ①
     foreach ($terms as $term):                             //   ②
     ?>
     <dd><a href="<?php echo get_term_link($term->slug, 'item_category'); ?>"><?php 
   echo htmlspecialchars($term->name); ?></a></dd>  // ③
     <?php
     endforeach;
     ?>
     <dt>価格</dt>
     <dd><?php echo number_format(get_field('価格')); ?>円</dd>
     <dt>発売日</dt>
     <dd><?php the_field('発売日'); ?></dd>
   </dl>
   ```
   ①[get_the_terms](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_the_terms/)：投稿に割り当てられたタクソノミーのターム（カスタム分類の項目）を取得する。</br>
   ②指定したタクソノミーすべてを取るため配列の形で取得する。その投稿に指定されたタクソノミーすべてを表示させるために、`foreach`で配列の中身をすべて表示させる。</br>
   ③[get_term_link](https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/get_term_link/)：表示されたカテゴリー名(タクソノミー)にカテゴリー別ページのリンクを取得させるため、そのタクソノミーごとのスラッグ(分類ごとに指定されたアドレスの一部みたいなもの)を取得する。</br>
</br>

## 第11回の内容
### ヘッダー・フッターとページテンプレートについて
概要：ヘッダーやフッターなど各ページ共通の部分を切り出して個別のファイルとする。
1. まずヘッダー(実際はhead要素)から切り出していく。
   一例として一番上部の`<!DOCTYPE html>`からheaderまでを切りだして、body要素だけ残すというやり方(`<?php get_header(); ?>`のように記述する)もできる。</br>
   しかしこのやり方だとエディターによってはエラーが発生する場合がある。理由はbodyタグをぶった切ってしまう事から。</br>
   そのためhead要素のみ切り出してやるやり方を推奨する。</br>
   `index.php`を下記のように編集。
   ```php
   <head>
    <?php get_header(); ?>  // 中身をすべて切り出す。
   </head>
   ```
   上記から切り取った内容を**header.php**という名前のファイルを作成して貼り付ける。</br>
   他のファイルのhead要素も同じようにする。</br>
2. 次にフッター</br>
   フッターもhead要素同様にbody要素を切らないように等、一部のみを切り出すようにする。
   `index.php`を下記のように編集。
   ```php
      </footer>
 
      <!-- Bootstrap core JavaScript -->
      <script src="<?php echo get_template_directory_uri(); ?>/vendor/ jquery/jquery.min.js"></script>
      <script src="<?php echo get_template_directory_uri(); ?>/vendor/ bootstrap/js/bootstrap.bundle.min.js"></script>
     
      <!-- Custom scripts for this template -->
      <script src="<?php echo get_template_directory_uri(); ?>/js/ clean-blog.min.js"></script>
     
      <?php wp_footer(); ?>
    </body>
    
    </html>
   ```
    ↓
   ```php
       </footer>
       <?php get_footer(); ?>
       </body>
    
    </html>
   ```

  </br>
  ヘッダーと同様に上記から切り取った内容を**footer.php**という名前のファイルを作成して貼り付ける。</br>
  
  **補足**：そのほかに`<?php get_sidebar(); ?>`のようにしてサイドバーを切り出す事も可能。</br>
  </br>
  
3. その他WordPressではどんなパーツでも切り出して共通部分として使用する事ができる。
   今回はbody要素上部のゔ`Navigation`という部分を切り出す。
   ```php
   <body>

   <!-- Navigation -->
   <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
     <div class="container">
       <a class="navbar-brand" href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
       <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
         Menu
         <i class="fas fa-bars"></i>
       </button>
       <div class="collapse navbar-collapse" id="navbarResponsive">
         <ul class="navbar-nav ml-auto">
           <li class="nav-item">
             <a class="nav-link" href="index.html">Home</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="about.html">About</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="post.html">Sample Post</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="contact.html">Contact</a>
           </li>
         </ul>
       </div>
     </div>
   </nav>
   ↓
   <body>

   <?php get_template_part('includes/nav'); ?>
   // 説明は下記。
   ```
   まずフォルダを作成(今回は"includes"という名前で設定するが名前はなんでもよい)。</br>
   その中に仮に`nav.php`という名前でファイルを作成して切り出した部分を貼り付ける。</br>
   次にもとの`Navigation`があった場所に`<?php get_template_part('includes/nav')>`と記述する。この際、パラメータに入れるのは先程作成した切り出しファイルの相対パス。".php"は書かなくて良い。</br>
   </br>
   同様の方法で`footer`(先程のfooterとは別)も切り出してみる。</br>
   `index.php`を下記のように編集。
   ```php
    <!-- Footer -->
     <?php get_template_part('includes/footer02'); ?>
   
     <?php get_footer(); ?>
     </body>
   </html>
   ```
   先程と区別するため"includes"の中に`footer02`という名前のファイルを作成し、切り出した部分を貼り付ける。







