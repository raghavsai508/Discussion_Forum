<?php include 'header.php';?>

<!--<div class="btn-toolbar search-dropdown" style="float:left;margin-right:10px;">
    <div class="btn-group">
        <button class="btn btn-small">All Types</button>
        <button data-toggle="dropdown" class="btn btn-small dropdown-toggle"><span class="caret"></span>
        </button>
        <ul class="dropdown-menu" id="search-type">
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="tv" value="TV">TV</input></label>
            </li>
            <li>
                <label class="checkbox">
                    <input type="checkbox" name="movies" value="Movies">Movies</input></label>
            </li>
        </ul>
    </div>
</div>-->
<div class="btn-group btn-input clearfix">
  <button type="button" class="btn btn-default dropdown-toggle form-control" data-toggle="dropdown">
    <span data-bind="label">Select One</span> <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="#">Item 1</a></li>
    <li><a href="#">Another item</a></li>
    <li><a href="#">This is a longer item that will not fit properly</a></li>
  </ul>
</div>

<!--<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <a href="index.php" class = "navbar-brand">Programming Cards</a>

        <!--Creats button for navigation when window gets too small-->
        <button class = "navbar-toggle" data-toggle = "collapse" data-target= ".navHeaderCollapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="collapse navbar-collapse navHeaderCollapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="upload.php">Upload</a></li>
                <li>
                    <form action="index.php" method="POST" id="my_form">
                        <input type="hidden" name="topic" id="topic">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Topic Select<b class="caret"></b>
                                <ul class="dropdown-menu">
                                    <li>Introduction</li>
                                    <li>Methods</li>
                                    <li>Loops</li>
                                    <li>Conditional Logic</li>
                                </ul>
                            </a>
                        </li>
                    </form>

                    <script>
                    $(function() 
                    {
                        $('.dropdown-menu li').click(function()
                        {
                            $('#topic').val($(this).html());
                            $('#my_form').submit();
                        });
                    });
                    </script>
                </li>
            </ul>
        </div>
    </div>
</div>-->