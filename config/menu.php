<?php

declare(strict_types=1);

    return [

        /*
        |--------------------------------------------------------------------------
        | Admin Menu
        |--------------------------------------------------------------------------
        */

        'administrator' => [
            'side' => [

                /*
                |--------------------------------------------------------------------------
                | Dashboard
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Dashboard',
                    'class' => 'nav-link rounded text-white',
                    'toggleId' => 'dashboard-collapse',
                    'iconClass' => 'home',
                    'hasChildren' => false,
                    'routeName' => 'dashboard',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Dashboard'],
                    'subMenus' => [],
                ],

                /*
                |--------------------------------------------------------------------------
                | User module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Users',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'hospital-user',
                    'toggleId' => 'user-collapse',
                    'hasChildren' => true,
                    'routeName' => 'admin.announcements',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Announcements'],
                    'subMenus' => [
                        [
                            'name' => 'User List',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'clipboard-list',
                            'hasChildren' => false,
                            'routeName' => 'admin.user.list',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Announcements'],
                        ],
                        [
                            'name' => 'Create User',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'plus',
                            'hasChildren' => false,
                            'routeName' => 'admin.user.create',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Announcements'],
                        ],
                    ],
                ],

                /*
                |--------------------------------------------------------------------------
                | Position module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Position',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'file-contract',
                    'toggleId' => 'position-collapse',
                    'hasChildren' => true,
                    'routeName' => 'admin.announcements',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Announcements'],
                    'subMenus' => [
                        [
                            'name' => 'Position List',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'clipboard-list',
                            'hasChildren' => false,
                            'routeName' => 'admin.positions.list',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Announcements'],
                        ],
                        [
                            'name' => 'Create Position',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'plus',
                            'hasChildren' => false,
                            'routeName' => 'admin.positions.create',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Announcements'],
                        ],
                    ],
                ],

                /*
                |--------------------------------------------------------------------------
                | Announcement module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Announcements',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'headphones',
                    'toggleId' => 'announcement-collapse',
                    'hasChildren' => true,
                    'routeName' => 'admin.announcements',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Announcements'],
                    'subMenus' => [
                        [
                            'name' => 'Announcement List',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'clipboard-list',
                            'hasChildren' => true,
                            'routeName' => 'admin.announcements.list',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Announcements'],
                        ],
                        [
                            'name' => 'Post Announcement',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'plus',
                            'hasChildren' => true,
                            'routeName' => 'admin.announcements.create',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Announcements'],
                        ],
                    ],
                ],

                /*
                |--------------------------------------------------------------------------
                | Handbook module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Handbook',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'book',
                    'toggleId' => 'handbook-collapse',
                    'hasChildren' => false,
                    'routeName' => 'handbook',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Handbook'],
                    'subMenus' => [],
                ],

                /*
                |--------------------------------------------------------------------------
                | Attendance module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Attendance',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'file-contract',
                    'toggleId' => 'attendance-collapse',
                    'hasChildren' => false,
                    'routeName' => 'attendance',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Attendance'],
                    'subMenus' => [],
                ],

                /*
                |--------------------------------------------------------------------------
                | Course module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Course',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'headphones',
                    'toggleId' => 'course-collapse',
                    'hasChildren' => true,
                    'routeName' => 'admin.courses',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Courses'],
                    'subMenus' => [
                        [
                            'name' => 'Category',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'clipboard-list',
                            'hasChildren' => true,
                            'routeName' => 'admin.course.category.list',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Courses'],
                        ],
                        [
                            'name' => 'Courses',
                            'class' => 'nav-link rounded text-white',
                            'iconClass' => 'clipboard-list',
                            'hasChildren' => true,
                            'routeName' => 'admin.course.list',
                            'imgIcon' => 'lead-icon.png',
                            'permissions' => ['Courses'],
                        ],
                    ],
                ],
            ],
            'top' => [
                [
                    'name' => 'My Profile',
                    'class' => 'dropdown-item',
                    'iconClass' => 'el-icon-s-custom',
                    'hasChildren' => false,
                    'routeName' => 'my.profile',
                    'permissions' => ['My Profile'],
                    'subMenus' => [],
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Employee Menu
        |--------------------------------------------------------------------------
        */

        'employee' => [
            'side' => [

                /*
                |--------------------------------------------------------------------------
                | Dashboard
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Dashboard',
                    'class' => 'nav-link rounded btn-toggle align-items-center collapsed text-white',
                    'iconClass' => 'home',
                    'hasChildren' => false,
                    'routeName' => 'dashboard',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Dashboard'],
                    'subMenus' => [],
                ],

                /*
                |--------------------------------------------------------------------------
                | Announcement module menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Announcements',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'headphones',
                    'hasChildren' => false,
                    'routeName' => 'front.announcements',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Announcements'],
                    'subMenus' => [],
                ],

                /*
                |--------------------------------------------------------------------------
                | Handbook modules menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Handbook',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'book',
                    'toggleId' => 'handbook-collapse',
                    'hasChildren' => false,
                    'routeName' => 'handbook',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Handbook'],
                    'subMenus' => [],
                ],

                /*
                |--------------------------------------------------------------------------
                | Attendance modules menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Attendance',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'file-contract',
                    'toggleId' => 'attendance-collapse',
                    'hasChildren' => false,
                    'routeName' => 'attendance',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Attendance'],
                ],

                /*
                |--------------------------------------------------------------------------
                | Courses modules menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'Courses',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'file-contract',
                    'toggleId' => 'courses-collapse',
                    'hasChildren' => false,
                    'routeName' => 'courses',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Courses'],
                ],

                /*
                |--------------------------------------------------------------------------
                | My Courses modules menu
                |--------------------------------------------------------------------------
                */
                [
                    'name' => 'My Courses',
                    'class' => 'nav-link rounded text-white',
                    'iconClass' => 'file-contract',
                    'toggleId' => 'my-courses-collapse',
                    'hasChildren' => false,
                    'routeName' => 'my-courses',
                    'imgIcon' => 'lead-icon.png',
                    'permissions' => ['Courses'],
                ],
            ],
            'top' => [
                [
                    'name' => 'Announcements',
                    'class' => 'dropdown-item',
                    'iconClass' => 'icon-user',
                    'hasChildren' => false,
                    'routeName' => 'profile',
                    'permissions' => ['My Profile'],
                    'subMenus' => [],
                ],
                [
                    'name' => 'My Profile',
                    'class' => 'dropdown-item',
                    'iconClass' => 'icon-user',
                    'hasChildren' => false,
                    'routeName' => 'profile',
                    'permissions' => ['My Profile'],
                    'subMenus' => [],
                ],
                [
                    'name' => 'Logout',
                    'class' => 'dropdown-item',
                    'iconClass' => 'el-icon-switch-button',
                    'hasChildren' => false,
                    'routeName' => 'logout',
                    'subMenus' => [],
                ],
            ],
        ],

    ];
