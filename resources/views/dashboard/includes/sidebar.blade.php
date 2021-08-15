<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item active"><a href=""><i class="la la-mouse-pointer"></i><span
                        class="menu-title" data-i18n="nav.add_on_drag_drop.main">الرئيسية </span></a>
            </li>

            @can('categories')
                <li class="nav-item"><a href=""><i class="la la-group"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">الاقسام  </span>
                        <span
                            class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Category::count()}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.Categories')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.Categories.create')}}"
                               data-i18n="nav.dash.crypto">أضافة
                                قسم جديد </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('brands')

                <li class="nav-item"><a href=""><i class="la la-group"></i>
                        <span class="menu-title" data-i18n="nav.dash.main"> الماركات التجارية  </span>
                        <span
                            class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Brand::count()}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.brands')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.brands.create')}}" data-i18n="nav.dash.crypto">أضافة
                                ماركة جديده </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('tags')

                <li class="nav-item"><a href=""><i class="la la-group"></i>
                        <span class="menu-title" data-i18n="nav.dash.main"> العلامات tags  </span>
                        <span
                            class="badge badge badge-danger badge-pill float-right mr-2">{{\App\Models\Tag::count()}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.tags')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.tags.create')}}" data-i18n="nav.dash.crypto">أضافة
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('products')

                <li class="nav-item"><a href=""><i class="la la-male"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">المنتجات  </span>
                        <span
                            class="badge badge badge-success badge-pill float-right mr-2"> {{\App\Models\Product::count()}}</span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.products')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.products.general.create')}}"
                               data-i18n="nav.dash.crypto">أضافة
                                منتج جديد </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('attribute')

                <li class="nav-item"><a href=""><i class="la la-male"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">خصائص المنتج  </span>
                        <span
                            class="badge badge badge-success badge-pill float-right mr-2"> </span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.attributes')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.attributes.create')}}"
                               data-i18n="nav.dash.crypto">اضافة
                                جديدة </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('options')

                <li class="nav-item"><a href=""><i class="la la-male"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">قيم الخصائص </span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.options')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.options.create')}}" data-i18n="nav.dash.crypto">أضافة
                                جديدة </a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li class="nav-item"><a href=""><i class="la la-male"></i>
                    <span class="menu-title" data-i18n="nav.dash.main">الصلاحيات </span>
                </a>
                <ul class="menu-content">
                    <li class="active"><a class="menu-item" href="{{route('admin.roles.index')}}"
                                          data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                    </li>
                    <li><a class="menu-item" href="{{route('admin.roles.create')}}" data-i18n="nav.dash.crypto">أاضافة
                            جديدة </a>
                    </li>
                </ul>
            </li>
            @can('users')

                <li class="nav-item"><a href=""><i class="la la-male"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">مستخدمي لوحه التحكم </span>
                    </a>
                    <ul class="menu-content">
                        <li class="active"><a class="menu-item" href="{{route('admin.users.index')}}"
                                              data-i18n="nav.dash.ecommerce"> عرض الكل </a>
                        </li>
                        <li><a class="menu-item" href="{{route('admin.users.create')}}" data-i18n="nav.dash.crypto">أاضافة
                                جديدة </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('setting')

                <li class=" nav-item"><a href="#"><i class="la la-television"></i><span class="menu-title"
                                                                                        data-i18n="nav.templates.main">{{__('admin/sidebar.settings')}}</span></a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="#"
                               data-i18n="nav.templates.vert.main">{{__('admin/sidebar.shipping methods')}}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{route('edit.shippings.methods','free')}}"
                                       data-i18n="nav.templates.vert.classic_menu">توصيل مجاني</a>
                                </li>
                                <li><a class="menu-item" href="{{route('edit.shippings.methods','inner')}}">توصيل
                                        داخلي</a>
                                </li>
                                <li><a class="menu-item" href="{{route('edit.shippings.methods','outer')}}"
                                       data-i18n="nav.templates.vert.compact_menu">توصيل خارجي</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
            @endcan
            @can('sliders')

                <li><a class="menu-item" href="#"
                       data-i18n="nav.templates.vert.main"> {{__('admin/sidebar.main slider')}} </a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{route('admin.sliders.create')}}"
                               data-i18n="nav.templates.vert.classic_menu">صور الاسليدر </a>
                        </li>
                    </ul>
                </li>
        @endcan

    </div>

</div>
