<!DOCTYPE html>
<html>

<head>
    <!-- -------------- Meta and Title -------------- -->
    <meta charset="utf-8">
    <title> HRMS </title>
    <meta name="keywords" content="HTML5, Bootstrap 3, Admin Template, UI Theme"/>
    <meta name="description" content="Alliance - A Responsive HTML5 Admin UI Framework">
    <meta name="author" content="ThemeREX">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- -------------- Fonts -------------- -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,300italic,400italic,700,700italic' rel='stylesheet'
          type='text/css'>


    <!-- -------------- Icomoon -------------- -->
    <?php echo Html::style('/assets/fonts/icomoon/icomoon.css'); ?>


            <!-- -------------- CSS - theme -------------- -->
    <?php echo Html::style('/assets/skin/default_skin/css/theme.css'); ?>


            <!-- -------------- CSS - allcp forms -------------- -->
    <?php echo Html::style('/assets/allcp/forms/css/forms.css'); ?>


    <?php echo Html::style('/assets/custom.css'); ?>

    <?php echo Html::style('/assets/dibcustom.css'); ?>


            <!-- -------------- Favicon -------------- -->
    <link rel="shortcut icon" href="/assets/img/favicon.png">

    <!-- -------------- IE8 HTML5 support  -------------- -->
    <!--[if lt IE 9]>
    <?php echo Html::script('https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.js'); ?>

    <?php echo Html::script('https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js'); ?>

    <![endif]-->

</head>

<body class="forms-wizard">

<!-- -------------- Customizer -------------- -->
<div id="customizer">
    <div class="panel">
<!--        <div class="panel-heading">
        <span class="panel-icon">
          <i class="fa fa-cogs"></i>
        </span>
            <span class="panel-title"> Theme Options</span>
        </div>-->
        <div class="panel-body pn">
            <ul class="nav nav-list nav-list-sm" role="tablist">
                <li class="active">
                    <a href="customizer-header" role="tab" data-toggle="tab">Navbar</a>
                </li>
                <li>
                    <a href="customizer-sidebar" role="tab" data-toggle="tab">Sidebar</a>
                </li>
                <li>
                    <a href="customizer-settings" role="tab" data-toggle="tab">Misc</a>
                </li>
            </ul>
            <div class="tab-content p20 ptn pb15">
                <div role="tabpanel" class="tab-pane active" id="customizer-header">
                    <form id="customizer-header-skin">
                        <h6 class="mv20">Header Skins</h6>

                        <div class="customizer-sample">
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-dark mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin5" checked
                                                   value="bg-dark">
                                            <label for="headerSkin5">Dark</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-warning mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin2" value="bg-warning">
                                            <label for="headerSkin2">Warning</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-danger mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin3" value="bg-danger">
                                            <label for="headerSkin3">Danger</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-success mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin4" value="bg-success">
                                            <label for="headerSkin4">Success</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-primary mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin6" value="bg-primary">
                                            <label for="headerSkin6">Primary</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-info mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin7" value="bg-info">
                                            <label for="headerSkin7">Info</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-alert mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin8" value="bg-alert">
                                            <label for="headerSkin8">Alert</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-system mb10">
                                            <input type="radio" name="headerSkin" id="headerSkin9" value="bg-system">
                                            <label for="headerSkin9">System</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="checkbox-custom checkbox-disabled fill mb10">
                                <input type="radio" name="headerSkin" id="headerSkin1" value="bgc-light">
                                <label for="headerSkin1">Light</label>
                            </div>
                        </div>
                    </form>
                    <form id="customizer-footer-skin">
                        <h6 class="mv20">Footer Skins</h6>

                        <div class="customizer-sample">
                            <table>
                                <tr>
                                    <td>
                                        <div class="checkbox-custom fill checkbox-dark mb10">
                                            <input type="radio" name="footerSkin" id="footerSkin1" checked value="">
                                            <label for="footerSkin1">Dark</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="checkbox-custom checkbox-disabled fill mb10">
                                            <input type="radio" name="footerSkin" id="footerSkin2" value="footer-light">
                                            <label for="footerSkin2">Light</label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="customizer-sidebar">
                    <form id="customizer-sidebar-skin">
                        <h6 class="mv20">Sidebar Skins</h6>

                        <div class="customizer-sample">
                            <div class="checkbox-custom fill checkbox-dark mb10">
                                <input type="radio" name="sidebarSkin" checked id="sidebarSkin2" value="">
                                <label for="sidebarSkin2">Dark</label>
                            </div>
                            <div class="checkbox-custom fill checkbox-disabled mb10">
                                <input type="radio" name="sidebarSkin" id="sidebarSkin1" value="sidebar-light">
                                <label for="sidebarSkin1">Light</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="customizer-settings">
                    <form id="customizer-settings-misc">
                        <h6 class="mv20 mtn">Layout Options</h6>

                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" checked="" id="header-option">
                                <label for="header-option">Fixed Header</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" checked="" id="sidebar-option">
                                <label for="sidebar-option">Fixed Sidebar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" id="breadcrumb-option">
                                <label for="breadcrumb-option">Fixed Breadcrumbs</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox-custom fill mb10">
                                <input type="checkbox" id="breadcrumb-hidden">
                                <label for="breadcrumb-hidden">Hide Breadcrumbs</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="form-group mn pb35 pt25 text-center">
                <a href="#" id="clearAll" class="btn btn-primary btn-bordered btn-sm">Clear All</a>
            </div>
        </div>
    </div>
</div>
<!-- -------------- /Customizer -------------- -->

<!-- -------------- Body Wrap  -------------- -->
<div id="main">

    <!-- -------------- Header  -------------- -->
    <?php echo $__env->make('hrms.layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- -------------- /Header  -------------- -->

    <!-- -------------- Sidebar  -------------- -->
    <aside id="sidebar_left" class="nano nano-light affix">

        <!-- -------------- Sidebar Left Wrapper  -------------- -->
        <div class="sidebar-left-content nano-content">

            <!-- -------------- Sidebar Header -------------- -->
            <header class="sidebar-header">


                <?php echo $__env->make('hrms.layouts.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        <!-- -------------- Sidebar Hide Button -------------- -->
                <div class="sidebar-toggler">
                    <a href="/dashboard">
                        <span class="fa fa-arrow-circle-o-left"></span>
                    </a>
                </div>
                <!-- -------------- /Sidebar Hide Button -------------- -->

            </header>
        </div>
        <!-- -------------- /Sidebar Left Wrapper  -------------- -->

    </aside>

    <!-- -------------- Main Wrapper -------------- -->
    <section id="content_wrapper">

        <!-- -------------- Topbar -------------- -->
        <header id="topbar" class="alt">

            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>

                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <?php /* <li class="breadcrumb-active">
                             <a href="#"> Edit Details</a>
                         </li>*/ ?>
                        <li class="breadcrumb-link">
                            <a href="/dashboard"> Employees </a>
                        </li>
                        <li class="breadcrumb-current-item"> Edit details of <?php echo e($emps->name); ?> </li>
                    </ol>
                </div>

            <?php else: ?>

                <div class="topbar-left">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-icon">
                            <a href="/dashboard">
                                <span class="fa fa-home"></span>
                            </a>
                        </li>
                        <li class="breadcrumb-active">
                            <a href="/dashboard">Dashboard</a>
                        </li>
                        <li class="breadcrumb-link">
                            <a href="/add-employee"> Employees </a>
                        </li>
                        <li class="breadcrumb-current-item"> Add Details</li>
                    </ol>
                </div>

            <?php endif; ?>
        </header>
        <!-- -------------- /Topbar -------------- -->

        <!-- -------------- Content -------------- -->
        <section id="content" class="animated fadeIn">

            <div class="mw1000 center-block">
                <?php if(session('message')): ?>
                    <?php echo e(session('message')); ?>

                <?php endif; ?>
                <?php if(Session::has('flash_message')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session::get('flash_message')); ?>

                    </div>
                    <?php endif; ?>

                            <!-- -------------- Wizard -------------- -->
                    <!-- -------------- Spec Form -------------- -->
                    <div class="allcp-form">

                        <form method="post" <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?> action="<?php echo e(route('edit-emp',[$emps->id])); ?>" <?php else: ?> action="<?php echo e(route('add-employee')); ?>"  <?php endif; ?> id="custom-form-wizard" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                            <div class="wizard steps-bg steps-left">

                                <!-- -------------- step 1 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user pr5"></i> Personal Details</h4>
                                <section class="wizard-section">
                                    <div class="section">
                                        <label for="photo-upload"><h6 class="mb20 mt40"> Photo </h6></label>
                                        <label class="field prepend-icon append-button file">
                                            <span class="button">Choose File</span>
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="hidden" value="edit-emp/<?php echo e($emps->id); ?>" id="url">

                                                <input type="file" class="gui-file" name="photo" id="photo_upload"
                                                       value="<?php if($emps && $emps->photo): ?><?php echo e($emps->photo); ?><?php endif; ?>"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File">
                                                <label class="field-icon">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="hidden" value="add-employee" id="url">
                                                <input type="file" class="gui-file" name="photo" id="photo_upload"
                                                       onChange="document.getElementById('uploader1').value = this.value;">
                                                <input type="text" class="gui-input" id="uploader1"
                                                       placeholder="Select File">
                                                <label class="field-icon">
                                                    <i class="fa fa-cloud-upload"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>

                                    <!-- -------------- /section -------------- -->

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Employee Code</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_code" id="emp_code" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->code): ?><?php echo e($emps->employee->code); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_code" id="emp_code" class="gui-input"
                                                       placeholder="employee code..." required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-barcode"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">First name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_name" id="emp_name" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->name): ?><?php echo e($emps->employee->name); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_name" id="emp_name" class="gui-input"
                                                       placeholder="employee first name..." required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                            <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Last name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_last_name" id="emp_last_name" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->lastname): ?><?php echo e($emps->employee->lastname); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_last_name" id="emp_last_name" class="gui-input"
                                                       placeholder="employee last name..." required value="">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    
                                              <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">First name(Arabic) </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_name_ar" id="emp_name_ar" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->name_ar): ?><?php echo e($emps->employee->name_ar); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_name_ar" id="emp_name_ar" class="gui-input"
                                                       placeholder="employee first name in arabic..." required value=""> 
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                            <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Last name(Arabic) </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_last_name_ar" id="emp_last_name_ar" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->lastname_ar): ?><?php echo e($emps->employee->lastname_ar); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_last_name_ar" id="emp_last_name_ar" class="gui-input"
                                                       placeholder="employee last name in arabic..." required value="">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    
                            

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Iqama/National id </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_national_id" id="emp_national_id" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->national_id): ?><?php echo e($emps->employee->national_id); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_national_id" id="emp_national_id" class="gui-input"
                                                       placeholder="Iqama/National id" value="" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    
                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Email</h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="email" name="emp_email" id="emp_email" class="gui-input"
                                                       value="<?php if($emps && $emps->email): ?><?php echo e($emps->email); ?><?php endif; ?>" required readonly>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="email" name="emp_email" id="emp_email" class="gui-input"
                                                       placeholder="Email" value="" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>

                                        <div class="section">
                                            <label for="input002"><h6 class="mb20 mt40"> Role </h6></label>
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <select class="select2-single form-control" name="role" id="role" readonly required>
                                                    <option value="">Select role</option>
                                                    <?php foreach($roles as $role): ?>
                                                        <?php if($emps->role->role->id == $role->id): ?>
                                                            <option value="<?php echo e($role->id); ?>" selected><?php echo e($role->name); ?></option>
                                                        <?php endif; ?>
                                                        <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php else: ?>
                                                <select class="select2-single form-control" name="role" id="role">
                                                    <option value="">Select role</option>
                                                    <?php foreach($roles as $role): ?>
                                                        <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    
                                                <div class="section">
                                            <label for="input002"><h6 class="mb20 mt40"> Grade  </h6></label>
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <select class="select2-single form-control" name="emp_grade" id="emp_grade" readonly required>
                                                    <option value="">Select grade</option>
                                                    <?php foreach($grades as $grade): ?>
                                                        <?php if($emps->employee->grade == $grade['id']): ?>
                                                            <option value="<?php echo e($grade['id']); ?>" selected><?php echo e($grade['title']); ?></option>
                                                        <?php endif; ?>
                                                        <option value="<?php echo e($grade['id']); ?>"><?php echo e($grade['title']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php else: ?>
                                                <select class="select2-single form-control" name="emp_grade" id="emp_grade">
                                                    <option value="">Select grade</option>
                                                    <?php foreach($grades as $grade): ?>
                                                        <option value="<?php echo e($grade['id']); ?>"><?php echo e($grade['title']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Gender </h6></label>
                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="gender" id="gender"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->gender == '0'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Male</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="gender" id="gender"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->gender == '1'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Female</label>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker1" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Birth </h6></label>

                                        <div class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" id="datepicker1" class="gui-input fs13" name="dob"
                                                       value="<?php if($emps && $emps->employee->date_of_birth): ?><?php echo e($emps->employee->date_of_birth); ?><?php endif; ?>" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" id="datepicker1" class="gui-input fs13" name="dob" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker4" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Joining </h6></label>

                                        <div class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" id="datepicker4" class="gui-input fs13" name="doj"
                                                       value="<?php if($emps && $emps->employee->date_of_joining): ?><?php echo e($emps->employee->date_of_joining); ?><?php endif; ?>" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" id="datepicker4" class="gui-input fs13" name="doj" required>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Mobile Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="number" name="mob_number" id="mobile_phone"
                                                       class="gui-input phone-group" maxlength="10" minlength="10" required
                                                       value="<?php if($emps && $emps->employee->number): ?><?php echo e($emps->employee->number); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="number" name="mob_number" id="mobile_phone"
                                                       class="gui-input phone-group" maxlength="10" minlength="10" required
                                                       placeholder="mobile number...">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>

                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Qualification </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>

                                                <?php echo Form::select('qualification_list', qualification(),$emps->employee->qualification, ['class' => 'select2-single form-control qualification_select', 'id' => 'qualification']); ?>

                                                <?php if($emps->employee->qualification =='Other'): ?>
                                                <?php 
                                                   $class = '';
                                                ?>
                                           <?php else: ?>
                                            <?php 
                                                $class = 'hidden';
                                             ?>
                                       <?php endif; ?>
                                               
                                                <input type="text" id="qualification" name="qualification_text" class="gui-input form-control  qualification_text <?php echo e($class); ?>" placeholder="enter other qualification" value="<?php echo e($emps->employee->qualification); ?>"/>

                                            <?php else: ?>
                                               <?php echo Form::select('qualification_list', qualification(),'', ['class' => 'select2-single form-control qualification_select', 'id' => 'qualification']); ?>

                                               <input type="text" id="qualification" name="qualification_text" class="gui-input form-control hidden qualification_text" placeholder="enter other qualification"/>
                                            <?php endif; ?>
                                            </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Emergency Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="number" name="emer_number" id="emergency_number"
                                                       class="gui-input phone-group" maxlength="10" minlength="10"
                                                       value="<?php if($emps && $emps->employee->emergency_number): ?><?php echo e($emps->employee->emergency_number); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="number" name="emer_number" id="emergency_number"
                                                       class="gui-input phone-group" maxlength="10" minlength="10"
                                                       placeholder="Emergency number">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-mobile-phone"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40">Nationality </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_nationality" id="emp_nationality" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->nationality): ?><?php echo e($emps->employee->nationality); ?><?php endif; ?>" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" name="emp_nationality" id="emp_nationality" class="gui-input"
                                                       placeholder="Nationality..." value="" required>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-user"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section dib_display_hide">
                                        <label for="input002"><h6 class="mb20 mt40"> Father's Name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="father_name" id="father_name" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->father_name): ?><?php echo e($emps->employee->father_name); ?><?php endif; ?>">

                                            <?php else: ?>
                                                <input type="text" placeholder="Employees' father name"
                                                       name="father_name" id="father_name" class="gui-input">

                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Current Address </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="address" id="address" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->current_address): ?><?php echo e($emps->employee->current_address); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="current address..." name="address"
                                                       id="address" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-map-marker"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Permanent Address </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="permanent_address" id="permanent_address"
                                                       class="gui-input"
                                                       value="<?php if($emps && $emps->employee->permanent_address): ?><?php echo e($emps->employee->permanent_address); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-location-arrow"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="permanent address..."
                                                       name="permanent_address" id="permanent_address"
                                                       class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-location-arrow"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    <!-- -------------- /section -------------- -->
                                </section>

                                <!-- -------------- step 2 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-user-secret pr5"></i> Employment details</h4>
                                <section class="wizard-section">
                                    <!-- -------------- /section -------------- -->
                                   <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Employee type </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" class="dib_employee_type" name="employee_type"
                                                       id="employee_type"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->employee_type == 1): ?>checked <?php endif; ?> <?php endif; ?> >
                                                <span class="radio"></span>Saudi</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" class="dib_employee_type" name="employee_type"
                                                       id="employee_type"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->employee_type == 0): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Non-saudi</label>
                                        </div>
                                    </div> 
                                    
                                    
                                    <div class="section dib_display_hide">
                                        <label for="input002"><h6 class="mb20 mt40"> Joining Formalities </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="formalities"
                                                       id="formalities"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->formalities == '1'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Completed</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="formalities" id="formalities"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->formalities == '0'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Pending</label>
                                        </div>
                                    </div>

                                    <div class="section dib_display_hide">
                                        <label for="input002"><h6 class="mb20 mt40"> Offer Acceptance </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="offer_acceptance"
                                                       id="offer_acceptance"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->offer_acceptance == '1'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Completed</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="offer_acceptance"
                                                       id="offer_acceptance"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->offer_acceptance == '0'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Pending</label>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Probation Period </h6></label>

                                                <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                            <select class="select2-single form-control probation_select" name="probation_period" id="probation_period" >
                                                <option value="">Select probation period</option>
                                                    <?php if($emps->employee->probation_period == '0'): ?>
                                                        <option value="0" selected>0 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="180">180 days</option>
                                                        <option value="Other">Other</option>
                                                         </select>
                                                    <?php elseif($emps->employee->probation_period == '90'): ?>
                                                        <option value="0">0 days</option>
                                                        <option value="90" selected>90 days</option>
                                                        <option value="180">180 days</option>
                                                        <option value="Other">Other</option>
                                                         </select>
                                                    <?php elseif($emps->employee->probation_period == '180'): ?>
                                                        <option value="0">0 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="180" selected>180 days</option>
                                                        <option value="Other">Other</option>
                                                         </select>
                                                     <?php else: ?>
                                                        <option value="0">0 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="180">180 days</option>
                                                        <option value="Other" selected>Other</option>
                                                         </select>
                                                          <input type="text" class="form-control probation_text" name="probation_text" id="probation_text" value=<?php echo e($emps->employee->probation_period); ?> >
                                                    <?php endif; ?>
                                           
                                                   
                                                <?php else: ?>
                                                    <select class="select2-single form-control probation_select" name="probation_period" id="probation_period" >
                                                    <option value="">Select probation period</option>
                                                    <option value="0">0 days</option>
                                                    <option value="90">90 days</option>
                                                    <option value="180">180 days</option>
                                                    <option value="Other">Other</option>
                                                    </select>
                                            <input type="text" class="form-control probation_text hidden" id="probation_text" name="probation_text">
                                                <?php endif; ?>


                                    </div>



                                    <div class="section">
                                        <label for="datepicker5" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Confirmation </h6></label>

                                        <div class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" id="datepicker5" class="gui-input fs13" name="date_of_confirmation"
                                                       value="<?php if($emps && $emps->employee->date_of_confirmation): ?><?php echo e($emps->employee->date_of_confirmation); ?><?php endif; ?>"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" id="datepicker5" class="gui-input fs13" name="doc"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Department </h6></label>
                                           <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>  
                                        
                                        <select class="select2-single form-control" name="department" id="department" required>
                                              
                                            <?php foreach($departments as $department): ?>
                                                        <?php if($emps->employee->department->id == $department->id): ?>
                                                            <option value="<?php echo e($department->id); ?>" selected><?php echo e($department->title); ?></option>
                                                        <?php endif; ?>
                                                        <option value="<?php echo e($department->id); ?>"><?php echo e($department->title); ?></option>
                                                    <?php endforeach; ?>
                                                                                        
                                         
                                            </select>
                                           <?php else: ?>
                                                <select class="select2-single form-control" name="department" id="department" required>
                                                    <option value="">Select manager</option>
                                                     <?php foreach($departments as $department): ?>
                                                        <option value="<?php echo e($department->id); ?>"><?php echo e($department->title); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                    </div>
                                       <div class="section">
                                            <label for="input002"><h6 class="mb20 mt40"> Direct manager </h6></label>
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <select class="select2-single form-control" name="direct_manager" id="direct_manager" readonly required>
                                                    <option value="">Select manager</option>
                                                    <?php foreach($employee as $employ): ?>
                                                        <?php if($employ->id == $emps->employee->direct_manager): ?>
                                                            <option value="<?php echo e($employ->id); ?>" selected><?php echo e($employ->name); ?></option>
                                                            <?php else: ?>
                                                        <option value="<?php echo e($employ->id); ?>"><?php echo e($employ->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php else: ?>
                                                <select class="select2-single form-control" name="direct_manager" id="direct_manager" required>
                                                    <option value="">Select manager</option>
                                                    <?php foreach($employee as $employ): ?>
                                                        <option value="<?php echo e($employ->id); ?>"><?php echo e($employ->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>

                                    
                                    


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Basic Salary </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="salary" id="salary" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->salary): ?><?php echo e($emps->employee->salary); ?><?php endif; ?>" >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="e.g 12000" name="salary"
                                                       id="salary" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    
                                       <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Housing allowance </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="housing_allowance" id="housing_allowance" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->housing_allowance): ?><?php echo e($emps->employee->housing_allowance); ?><?php endif; ?>" readonly>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php else: ?>
                                            
                                                <input type="text" placeholder="e.g 12000" name="housing_allowance"
                                                       id="housing_allowance" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                         <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Transportation </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="transportation_allowance" id="transportation_allowance" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->transportation_charge): ?><?php echo e($emps->employee->transportation_charge); ?><?php endif; ?>" >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="e.g 12000" name="transportation_allowance"
                                                       id="transportation_allowance" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Other allowance </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="emp_other_allowance" id="emp_other_allowance" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->other_allowance): ?><?php echo e($emps->employee->other_allowance); ?><?php endif; ?>" >
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="e.g 12000" name="emp_other_allowance"
                                                       id="emp_other_allowance" class="gui-input" value="0">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                    
                                    
                                     <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                        <?php if($emps && $emps->employee->employee_type ==1): ?>
                                            <?php 
                                              $class = '';
                                             ?>
                                        <?php else: ?>
                                            <?php 
                                                $class = 'dib_display_hide';
                                             ?>
                                       <?php endif; ?>
                                       <?php else: ?>
                                            <?php 
                                                $class = 'dib_display_hide';
                                             ?>
                                     <?php endif; ?>
                                        <div class="section gossi-display <?php echo e($class); ?>">
                                        <label for="input002"><h6 class="mb20 mt40"> GOSI </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="employee_gosi" id="employee_gosi" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->employee_gosi): ?><?php echo e($emps->employee->employee_gosi); ?><?php endif; ?>" readonly>

                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php else: ?>
                                        
                                                <input type="hidden" name="employer_gosi" id="employer_gosi" class="gui-input"
                                                       value="0" readonly>
                                                <input type="text" name="employee_gosi" id="employee_gosi" class="gui-input"
                                                       value="0" readonly>
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                     
                                                                       
                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Ticket details </h6></label>
                                              <div class="row dib_ticket_numbers" style="margin-left:15%">
                                            <div class="form-group  col-md-4" style="width:180px">
                                             <label for="input002" class="col-md-2 control-label"> Self</label>

                                               <div class="col-md-10">

                                                 <input type='number' class="select2-single form-control" name='ticket_self' value='1' max='1' disabled min="0"/>
                                             </div>
                                         </div>
                                            <div class="form-group col-md-4" style="width:180px">
                                             <label for="input002" class="col-md-2 control-label"> Spouse</label>

                                               <div class="col-md-10">

                                                   <input type='number' class="select2-single form-control" name='ticket_spouse' value='<?php echo e((isset($emps) && $emps->employee->spouse_ticket) ? $emps->employee->spouse_ticket:0); ?>' max='5' min="0"/>
                                             </div>
                                         </div>
                                            <div class="form-group col-md-4" style="width:180px">
                                             <label for="input002" class="col-md-2 control-label"> Children</label>

                                               <div class="col-md-10">

                                                 <input type='number' class="select2-single form-control" name='ticket_children' value='<?php echo e((isset($emps) && $emps->employee->children_ticket) ? $emps->employee->children_ticket:0); ?>' max='4' min="0"/>
                                             </div>
                                         </div>
                                    
                                    </div>
                                    </div>  
                                     
                                     
                                     
                                      <?php if(\Route::getFacadeRoot()->current()->uri() !== 'edit-emp/{id}'): ?>
                                          <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Upload joining related files </h6>
                                        </label>
                                        <label for="input002" class="field prepend-icon">
                                      
                                                <input type="file"  name="emp_appointment_doc[]"
                                                       id="emp_appointment_doc" class="gui-input" value="" multiple="multiple">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-inr"></i>
                                                </label>
                                           
                                        </label>
                                    </div>
                                    
                                     <?php endif; ?>
                                    
                                    
                                    <!-- -------------- /section -------------- -->


                                </section>

                                <!-- -------------- step 3 -------------- -->
                                <h4 class="wizard-section-title">
                                    <i class="fa fa-file-text pr5"></i>Banking Details</h4>
                                <section class="wizard-section">


                                    <!-- -------------- /section -------------- -->


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Bank Account Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="account_number" id="bank_account_number"
                                                       class="gui-input"
                                                       value="<?php if($emps && $emps->employee->account_number): ?><?php echo e($emps->employee->account_number); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="Bank account number"
                                                       name="account_number" id="bank_account_number" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Bank Name </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="bank_name" id="bank_name" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->bank_name): ?><?php echo e($emps->employee->bank_name); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-columns"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="name of bank..." name="bank_name"
                                                       id="bank_name" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-columns"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> IBAN </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="ifsc_code" id="ifsc_code" class="gui-input"
                                                       value="<?php if($emps && $emps->employee->ifsc_code): ?><?php echo e($emps->employee->ifsc_code); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-font"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="Iban" name="ifsc_code"
                                                       id="ifsc_code" class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-font"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>


                                    <div class="section dib_display_hide">
                                        <label for="input002"><h6 class="mb20 mt40"> PF Account Number </h6></label>
                                        <label for="input002" class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" name="pf_account_number" id="pf_account_number"
                                                       class="gui-input hidden-field"
                                                       value="<?php if($emps && $emps->employee->pf_account_number): ?><?php echo e($emps->employee->pf_account_number); ?><?php endif; ?>">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" placeholder="PF account number..."
                                                       name="pf_account_number" id="pf_account_number"
                                                       class="gui-input">
                                                <label for="input002" class="field-icon">
                                                    <i class="fa fa-list"></i>
                                                </label>
                                            <?php endif; ?>
                                        </label>
                                    </div>

                                   <div class="section dib_display_hide">
                                       <label for="input002"><h6 class="mb20 mt40"> UN Number</h6></label>
                                       <label for="input002" class="field prepend-icon">
                                           <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                              <input type="text" name="un_number" id="un_number" class="gui-input hidden-field"
                                              value="<?php if($emps && $emps->employee->un_number): ?><?php echo e($emps->employee->un_number); ?><?php endif; ?>">
                                               <label for="input002" class="field-icon">
                                                   <i class="fa fa-list"></i>
                                               </label>
                                           <?php else: ?>
                                             <input type="text" placeholder="UN Number" name="un_number" id="un_number" class="gui-input hidden-field">
                                              <label for="input002" class="field-icon">
                                                  <i class="fa fa-list"></i>
                                              </label>
                                           <?php endif; ?>
                                       </label>
                                   </div>


                                    <div class="section dib_display_hide">
                                        <label for="input002"><h6 class="mb20 mt40"> PF Status </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="radio" value="1" name="pf_status" class="hidden-field" id="pf_status"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->pf_status == '1'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Active</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="pf_status" class="hidden-field" id="pf_status"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->pf_status == '0'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Inactive</label>
                                        </div>
                                    </div>
                                    <!-- -------------- /section -------------- -->

                                </section>


                                <h4 class="wizard-section-title">
                                    <i class="fa fa-file-text pr5"></i> Ex Employment Details </h4>
                                <section class="wizard-section">


                                    <div class="section">
                                        <label for="datepicker6" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Date of Resignation </h6></label>

                                        <div class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" id="datepicker6" class="gui-input fs13" name="dor"
                                                       value="<?php if($emps && $emps->employee->date_of_resignation): ?><?php echo e($emps->employee->date_of_resignation); ?><?php endif; ?>"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" id="datepicker6" class="gui-input fs13" name="dor"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Notice Period </h6></label>
                                            <select class="select2-single form-control" name="notice_period" id="notice_period">
                                                <option value="">Select notice period</option>
                                                <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                    <?php if($emps->employee->notice_period == '1'): ?>
                                                        <option value="1" selected>1 Month</option>
                                                        <option value="2">2 Months</option>
                                                    <?php else: ?>
                                                        <option value="1">1 Month</option>
                                                        <option value="2" selected>2 Months</option>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Months</option>
                                                <?php endif; ?>
                                            </select>
                                    </div>


                                    <div class="section">
                                        <label for="datepicker7" class="field prepend-icon mb5"><h6 class="mb20 mt40">
                                                Last Working Day </h6></label>

                                        <div class="field prepend-icon">
                                            <?php if(\Route::getFacadeRoot()->current()->uri() == 'edit-emp/{id}'): ?>
                                                <input type="text" id="datepicker7" class="gui-input fs13"
                                                       name="last_working_day"
                                                       value="<?php if($emps && $emps->employee->last_working_day): ?><?php echo e($emps->employee->last_working_day); ?> <?php endif; ?>"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php else: ?>
                                                <input type="text" id="datepicker7" class="gui-input fs13"
                                                       name="last_working_day"/>
                                                <label class="field-icon">
                                                    <i class="fa fa-calendar"></i>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <div class="section">
                                        <label for="input002"><h6 class="mb20 mt40"> Full & Final </h6></label>

                                        <div class="option-group field">
                                            <label class="field option mb5">
                                                <input type="hidden" value="<?php echo csrf_token(); ?>" id="token">
                                                <input type="radio" value="1" name="full_final" id="full_final"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->full_final == '1'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>Yes</label>
                                            <label class="field option mb5">
                                                <input type="radio" value="0" name="full_final" id="full_final"
                                                       <?php if(isset($emps)): ?><?php if($emps->employee->full_final == '0'): ?>checked <?php endif; ?> <?php endif; ?>>
                                                <span class="radio"></span>No</label>
                                        </div>
                                    </div>
                                </section>
                                
                                
                                
                                
                            </div>
                            <!-- -------------- /Wizard -------------- -->

                        </form>
                        <!-- -------------- /Form -------------- -->

                    </div>
                    <!-- -------------- /Spec Form -------------- -->

            </div>

        </section>
        <!-- -------------- /Content -------------- -->

    </section>

    <!-- -------------- Sidebar Right -------------- -->
    <aside id="sidebar_right" class="nano affix">

        <!-- -------------- Sidebar Right Content -------------- -->
        <div class="sidebar-right-wrapper nano-content">

            <div class="sidebar-block br-n p15">

                <h6 class="title-divider text-muted mb20"> Visitors Stats
                <span class="pull-right"> 2015
                  <i class="fa fa-caret-down ml5"></i>
                </span>
                </h6>

                <div class="progress mh5">
                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="34"
                         aria-valuemin="0"
                         aria-valuemax="100" style="width: 34%">
                        <span class="fs11">New visitors</span>
                    </div>
                </div>
                <div class="progress mh5">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="66"
                         aria-valuemin="0"
                         aria-valuemax="100" style="width: 66%">
                        <span class="fs11 text-left">Returnig visitors</span>
                    </div>
                </div>
                <div class="progress mh5">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45"
                         aria-valuemin="0"
                         aria-valuemax="100" style="width: 45%">
                        <span class="fs11 text-left">Orders</span>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt30 mb10">New visitors</h6>

                <div class="row">
                    <div class="col-xs-5">
                        <h3 class="text-primary mn pl5">350</h3>
                    </div>
                    <div class="col-xs-7 text-right">
                        <h3 class="text-warning mn">
                            <i class="fa fa-caret-down"></i> 15.7% </h3>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt25 mb10">Returnig visitors</h6>

                <div class="row">
                    <div class="col-xs-5">
                        <h3 class="text-primary mn pl5">660</h3>
                    </div>
                    <div class="col-xs-7 text-right">
                        <h3 class="text-success-dark mn">
                            <i class="fa fa-caret-up"></i> 20.2% </h3>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt25 mb10">Orders</h6>

                <div class="row">
                    <div class="col-xs-5">
                        <h3 class="text-primary mn pl5">153</h3>
                    </div>
                    <div class="col-xs-7 text-right">
                        <h3 class="text-success mn">
                            <i class="fa fa-caret-up"></i> 5.3% </h3>
                    </div>
                </div>

                <h6 class="title-divider text-muted mt40 mb20"> Site Statistics
                    <span class="pull-right text-primary fw600">Today</span>
                </h6>
            </div>
        </div>
    </aside>
    <!-- -------------- /Sidebar Right -------------- -->

</div>

<!-- -------------- /Body Wrap  -------------- -->

<!-- Notification modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="notification-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="modal-header" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /Notification Modal -->
<style>
    /*page demo styles*/
    .wizard .steps .fa,
    .wizard .steps .glyphicon,
    .wizard .steps .glyphicon {
        display: none;
    }
</style>

<!-- -------------- Scripts -------------- -->

<!-- -------------- jQuery -------------- -->
<?php echo Html::script('/assets/js/jquery/jquery-1.11.3.min.js'); ?>

<?php echo Html::script('/assets/js/jquery/jquery_ui/jquery-ui.min.js'); ?>


        <!-- -------------- HighCharts Plugin -------------- -->
<?php echo Html::script('/assets/js/plugins/highcharts/highcharts.js'); ?>


        <!-- -------------- MonthPicker JS -------------- -->
<?php echo Html::script('/assets/allcp/forms/js/jquery-ui-monthpicker.min.js'); ?>

<?php echo Html::script('/assets/allcp/forms/js/jquery-ui-datepicker.min.js'); ?>

<?php echo Html::script('/assets/allcp/forms/js/jquery.spectrum.min.js'); ?>

<?php echo Html::script('/assets/allcp/forms/js/jquery.stepper.min.js'); ?>



        <!-- -------------- Plugins -------------- -->
<?php echo Html::script('/assets/allcp/forms/js/jquery.validate.min.js'); ?>

<?php echo Html::script('/assets/allcp/forms/js/jquery.steps.min.js'); ?>


        <!-- -------------- Theme Scripts -------------- -->
<?php echo Html::script('/assets/js/utility/utility.js'); ?>

<?php echo Html::script('/assets/js/demo/demo.js'); ?>

<?php echo Html::script('/assets/js/main.js'); ?>

<?php echo Html::script('/assets/js/demo/widgets_sidebar.js'); ?>


<?php echo Html::script('/assets/js/custom_form_wizard.js'); ?>


<?php echo Html::script ('/assets/js/pages/forms-widgets.js'); ?>


        <!-- -------------- Select2 JS -------------- -->
<script src="/assets/js/plugins/select2/select2.min.js"></script>
<script src="/assets/js/function.js"></script>
<script>
$(function(){

 
    $(document).off('focusout','#salary');
    $(document).on('focusout','#salary',function(){
      
         var basic_salary = ($.trim($(this).val()) !=='') ? $(this).val(): 0;
         var housing_allowance = (basic_salary > 0) ? (basic_salary *.25) :0;         
         $('#housing_allowance').val(housing_allowance);
         var basic_salary = ($.trim($('#salary').val()) !=='') ? $('#salary').val(): 0;
          var housing_allowance = ($.trim($('#housing_allowance').val()) !=='') ? $('#housing_allowance').val(): 0;
          var total_salary = parseInt(basic_salary)+parseInt(housing_allowance);
          var gosi=0;
          var employerGosi =0;
         if($('input[name="employee_type"]:checked').val() == "0") {
          $('#employee_gosi').val(0);
          employerGosi = (total_salary > 0) ? (total_salary *.02) :0;
          $('#employer_gosi').val(employerGosi);
          $(".gossi-display").hide();
         } else {
           employerGosi = (total_salary > 0) ? (total_salary *.12) :0;
           gosi = (total_salary > 0) ? (total_salary *.10) :0;
           $('#employee_gosi').val(gosi);
           $('#employer_gosi').val(employerGosi);
           $(".gossi-display").show();
         }
       
         
         
     });
  
  
  //GOSI SETTING
   $(document).off('change','.dib_employee_type');
   $(document).on('change','.dib_employee_type',function(){
        if($(this).val() == 0) {
          $('#employee_gosi').val(0);
          $(".gossi-display").hide();
         } else {
           var basic_salary = ($.trim($('#salary').val()) !=='') ? $('#salary').val(): 0;
           var housing_allowance = ($.trim($('#housing_allowance').val()) !=='') ? $('#housing_allowance').val(): 0;
           var total_salary = parseInt(basic_salary)+parseInt(housing_allowance);
           var gosi = (total_salary > 0) ? (total_salary *.10) :0;
           $('#employee_gosi').val(gosi);
           $(".gossi-display").show();
         }
         
         
     });
  
  
  
  

});
</script>



<!-- -------------- /Scripts -------------- -->

</body>

</html>