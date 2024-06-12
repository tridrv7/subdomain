


<!--
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">SmartAdmin</a></li>
        <li class="breadcrumb-item">Datatables</li>
        <li class="breadcrumb-item active">Export</li>
        <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
    </ol>
-->




        <li>
            <a href="ui_breadcrumbs.html#"><i class="fal fa-home"></i></a>
        </li>
        <?PHP
        if(!empty($_REQUEST['bread'])){
            $txtbread = explode("_", $_REQUEST['bread']);
            for($i = 0;$i < count($txtbread);$i++){
                $txtbreadcrumb = str_replace("-"," ","$txtbread[$i]");
                echo '<li>'
                        .'<a href="ui_breadcrumbs.html#"><span class="hidden-md-down text-capitalize">'.$txtbreadcrumb.'</span></a>'
                    .'</li>';
            }
        } else {
            echo '<li>'
                    .'<a href="ui_breadcrumbs.html#"><span class="hidden-md-down text-capitalize">Dashboard</span></a>'
                .'</li>';
        }
        ?>

        
            
        



