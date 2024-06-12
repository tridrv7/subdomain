<?PHP
require '../conf/config.php';
require '../conf/phpFunction.php';

?>


                <!-- BEGIN Left Aside -->
                <aside class="page-sidebar">
                    <div class="page-logo">
						<img src="img/logo.png" alt="<?=loadRecText('ro_name', 'set_role', 'ro_id='.$_SESSION['usRole'])?>" aria-roledescription="logo">
						<span class="page-logo-text mr-1"><?=loadRecText('ro_name', 'set_role', 'ro_id='.$_SESSION['usRole'])?></span>
						<span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                    </div>
                    <!-- BEGIN PRIMARY NAVIGATION -->
                    <nav id="js-primary-nav" class="primary-nav" role="navigation">
                        <div class="nav-filter">
                            <div class="position-relative">
                                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                                    <i class="fal fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <ul id="js-nav-menu" class="nav-menu">
                            <li>
                                <a href="javascript:void(0)" onClick="goPage('_dash-marketing','dashboard','dashboard')">
                                    <i class="fal fa-tachometer-alt"></i>
                                    <span class="nav-link-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-title">Setting</li>
                            <li>
								<a href="javascript:void(0)">
									<i class="fal fa-cogs"></i>
									<span class="nav-link-text" data-i18n="nav.settings_roles">Roles</span>
								</a>
								<ul>
									<li>
										<a href="javascript:void(0)" onClick="goPage('_set-role','Hak-Akses','setting_roles_akses')">
											<span class="nav-link-text" data-i18n="nav.settings_layout_options">Akses</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPage('_set-page','page-akses','setting_roles_Halaman')">
											<span class="nav-link-text" data-i18n="nav.settings_layout_options">Halaman</span>
										</a>
									</li>
								</ul>
                            </li>
                            <li>
								<a href="javascript:void(0)">
									<i class="fal fa-cogs"></i>
									<span class="nav-link-text" data-i18n="nav.settings_layout">Layout</span>
								</a>
								<ul>
									<li>
										<a href="javascript:void(0)" onClick="goPage('_mast-form','Form-Model','setting_layout_Form')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_threads">Form</span>
										</a>
									</li>
									<!--
									<li>
										<a href="settings_layout_options.html" title="Layout Options" data-filter-tags="settings layout options">
											<span class="nav-link-text" data-i18n="nav.settings_layout_options">Layout Options</span>
										</a>
									</li>
									<li>
										<a href="settings_saving_db.html" title="Saving to Database" data-filter-tags="settings saving to database">
											<span class="nav-link-text" data-i18n="nav.settings_saving_to_database">Saving to Database</span>
										</a>
									</li>
									-->
								</ul>
                            </li>
                            <li>
								<a href="javascript:void(0)">
									<i class="fal fa-cogs"></i>
									<span class="nav-link-text" data-i18n="nav.settings_roles">Web</span>
								</a>
								<ul>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_page-pic','1','web-banner','setting_web_banner')">
											<span class="nav-link-text" data-i18n="nav.settings_layout_options">Banner</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPage('_set-menu','web-menu','setting_web_menu')">
											<span class="nav-link-text" data-i18n="nav.settings_layout_options">Menu</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_page-link','4','setting-url-API','setting_web_url-API')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_list">url <i>API</i></span>
										</a>
									</li>
								</ul>
                            </li>
                            <li>
								<a href="javascript:void(0)">
									<i class="fal fa-cogs"></i>
									<span class="nav-link-text" data-i18n="nav.settings_roles">OPD</span>
								</a>
								<ul>
									<li>
										<a href="javascript:void(0)" onClick="goPage('_page-profil','setting-profil','setting_OPD_profil')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_list">Profil</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_page-link','1','setting-sosial-media','setting_OPD_sosial-media')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_list">Sosial Media</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_mast-JabDept','1','setting-bidang-bagian','setting_OPD_bidang')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_list">Bagian/Bidang</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_mast-JabDept','2','setting-jabatan','setting_OPD_Jabatan')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_list">Jabatan</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_page-link','2','setting-link-terkait','setting_OPD_link-terkait')">
											<span class="nav-link-text" data-i18n="nav.pages_forum_list">Link Terkait</span>
										</a>
									</li>
								</ul>
                            </li>
                            <li class="nav-title">Master Data</li>
							<li>
								<a href="javascript:void(0)" onClick="goPage('_set-akun','data-User','master-data_user')">
									<i class="fal fa-users"></i>
									<span class="nav-link-text" data-i18n="nav.settings_user">User</span>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" onClick="goPage('_mast-kategori','Master-Kategori','master-data_Kategori')">
									<i class="fal fa-tags"></i>
									<span class="nav-link-text" data-i18n="nav.pages_forum_list">Kategori</span>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" onClick="goPage('_mast-emp','Master-Pegawai','master-data_Pegawai')">
									<i class="fal fa-tags"></i>
									<span class="nav-link-text" data-i18n="nav.pages_forum_list">Pegawai</span>
								</a>
							</li>
                            <li class="nav-title">Publikasi</li>
                            <li>
                                <a href="javascript:void(0)" title="Master Data" data-filter-tags="master data">
                                    <i class="fal fa-pen-square"></i>
                                    <span class="nav-link-text" data-i18n="nav.master_data">Data</span>
                                </a>
                                <ul>
									<!--
                                    <li>
                                        <a href="javascript:void(0)" onClick="goPage('_page-post','posting','halaman_posting')">
                                            <span class="nav-link-text" data-i18n="nav.settings_user">User</span>
                                        </a>
                                    </li>
									-->
									<?=hrefAside('a.ca_id, a.ca_nm, a.fm_id, b.fm_file', 'set_category a', 'LEFT JOIN set_form b ON a.fm_id=b.fm_id', 'a._active=1', '')?>									
                                </ul>
                            </li>
                            <li>
								<a href="javascript:void(0)">
									<i class="fal fa-images"></i>
									<span class="nav-link-text" data-i18n="nav.publikasi_galery">Galery</span>
								</a>
								<ul>
									<li>										
										<a href="javascript:void(0)" onClick="goPublic('_page-pic','2','publikasi-galery-foto','publikasi_galery_foto')">
											<span class="nav-link-text" data-i18n="nav.publikasi_galery_foto">Foto</span>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="goPublic('_page-link','3','publikasi-galery-video','publikasi_galery_video')">
											<span class="nav-link-text" data-i18n="nav.publikasi_galery_video">Video</span>
										</a>
									</li>
								</ul>
                            </li>
                        </ul>
                        <div class="filter-message js-filter-message bg-success-600"></div>
                    </nav>
                    <!-- END PRIMARY NAVIGATION -->
                    <!-- NAV FOOTER -->
                    <div class="nav-footer shadow-top">
                        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
                            <i class="ni ni-chevron-right"></i>
                            <i class="ni ni-chevron-right"></i>
                        </a>
                        <ul class="list-table m-auto nav-footer-buttons">
                            <li>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                                    <i class="fal fa-comments"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                                    <i class="fal fa-life-ring"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                                    <i class="fal fa-phone"></i>
                                </a>
                            </li>
                        </ul>
                    </div> <!-- END NAV FOOTER -->
                </aside>
                <!-- END Left Aside -->