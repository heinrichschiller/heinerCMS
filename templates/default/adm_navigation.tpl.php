<!-- Dashboard -->
<div class="list-group spacing">
        <a href="$PHP_SELF?uri=dashboard" class="list-group-item list-group-item-action active">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-dashboard.svg"> {dashboard}
        </a>
</div>

<!-- Content -->
<div class="list-group spacing">
    <li class="list-group-item active">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> {content}
    </li>
        <a href="$PHP_SELF?uri=news" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-pen.svg"> {news}
            <span class="badge badge-light">##placeholder-news##</span>
        </a>
        <a href="$PHP_SELF?uri=downloads" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-file-download.svg"> {downloads}
            <span class="badge badge-light">##placeholder-downloads##</span>
        </a>
        <a href="$PHP_SELF?uri=links" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-global.svg"> {links}
            <span class="badge badge-light">##placeholder-links##</span>
        </a>
        <a href="$PHP_SELF?uri=articles" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-pen.svg"> {articles}
            <span class="badge badge-light">##placeholder-articles##</span>
        </a>
        <a href="$PHP_SELF?uri=sites" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-document.svg"> {sites}
            <span class="badge badge-light">##placeholder-sites##</span>
        </a>
        <a href="$PHP_SELF?uri=trash" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-trash.svg"> {trash}
            <span class="badge badge-light">##placeholder-trash##</span>
        </a>
</div>

<!-- Communication -->
<div class="list-group spacing">
    <li class="list-group-item active">
        <span class="glyphicon glyphicon-book" aria-hidden="true"></span> {communication}
    </li>
        <a href="$PHP_SELF?uri=news" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-contact-book.svg"> {contact_inquiry}
            <span class="badge badge-light">0<!-- ##placeholder-inqiery##  --></span>
        </a>
</div>

<!-- Settings -->
<div class="list-group spacing">
    <li class="list-group-item active">
        <img class="glyph-icon-24" src="../templates/default/img/svg/si-glyph-gear-1.svg"> {settings}
    </li>
        <a href="$PHP_SELF?uri=general" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-gear.svg"> {general}
        </a>
        <a href="$PHP_SELF?uri=mainpage" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-home-page.svg"> {mainpage}
        </a>
        <a href="$PHP_SELF?uri=linksettings" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-global.svg"> {links}
        </a>
        <a href="$PHP_SELF?uri=user" class="list-group-item list-group-item-action">
            <img class="glyph-icon-16" src="../templates/default/img/svg/si-glyph-person-people.svg"> {user}
        </a>
</div>
