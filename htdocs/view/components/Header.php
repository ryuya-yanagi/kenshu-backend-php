<header class="header">
  <div class="header__container">
    <ul class="header__list">
      <li class="header__item">
        <a href="/">トップ</a>
      </li>
      <li class="header__item">
        <a href="/users/">ユーザ一覧</a>
      </li>
    </ul>
    <?php if (isset($_SESSION['username'])) : ?>
      <ul class="header__list">
        <li class="header__item">
          <a href="/mypage">マイページ</a>
        </li>
        <li class="header__item">
          <a href="/auth/logout">ログアウト</a>
        </li>
      </ul>
    <?php else : ?>
      <ul class="header__list">
        <li class="header__item">
          <a href="/auth/login">ログイン</a>
        </li>
        <li class="header__item">
          <a href="/users/new">サインアップ</a>
        </li>
      </ul>
    <?php endif; ?>
  </div>
</header>