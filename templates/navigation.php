<div class="container-fluid">
    <div class="list-group">
        <a href="$PHP_SELF?uri=dashboard" class="list-group-item">
            <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> Dashboard
        </a>
        </div>
        <div class="list-group">
        <li class="list-group-item active">
            <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Content
        </li>
        <a href="$PHP_SELF?uri=news" class="list-group-item">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> News
            <span class="badge"><?= $result[0]; ?></span>
        </a>
        <a href="$PHP_SELF?uri=downloads" class="list-group-item">
            <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Downloads
            <span class="badge"><?= $result[1]; ?></span>
        </a>
        <a href="$PHP_SELF?uri=links" class="list-group-item">
            <span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Links
            <span class="badge"><?= $result[2]; ?></span>
        </a>
        <a href="$PHP_SELF?uri=articles" class="list-group-item">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Articles
            <span class="badge"><?= $result[3]; ?></span>
        </a>
        <a href="$PHP_SELF?uri=trash" class="list-group-item">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Trash
            <span class="badge"><?= $result[4]; ?></span>
        </a>
        </div>
        <div class="list-group">
            <li class="list-group-item active">
                <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Settings
            </li>
            <a href="$PHP_SELF?uri=general" class="list-group-item">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> General
            </a>
            <a href="$PHP_SELF?uri=user" class="list-group-item">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> User
            </a>
    </div>
</div>