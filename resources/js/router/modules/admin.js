/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/administrator',
  component: Layout,
  redirect: '/administrator/users',
  name: 'Administrator',
  alwaysShow: true,
  meta: {
    title: 'administrator',
    icon: 'admin',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    {
      path: 'users/edit/:id(\\d+)',
      component: () => import('@/views/users/UserProfile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: 'users',
      component: () => import('@/views/users/List'),
      name: 'UserList',
      meta: { title: 'users', icon: 'user', permissions: ['manage user'] },
    },
    /** Role and permission */
    {
      path: 'roles',
      component: () => import('@/views/role-permission/List'),
      name: 'RoleList',
      meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    },
    {
      path: 'articles/create',
      component: () => import('@/views/articles/Create'),
      name: 'CreateArticle',
      meta: { title: 'createArticle', icon: 'edit', permissions: ['manage article'] },
      hidden: true,
    },
    {
      path: 'articles/edit/:id(\\d+)',
      component: () => import('@/views/articles/Edit'),
      name: 'EditArticle',
      meta: { title: 'editArticle', noCache: true, permissions: ['manage article'] },
      hidden: true,
    },
    {
      path: 'articles',
      component: () => import('@/views/articles/List'),
      name: 'ArticleList',
      meta: { title: 'articleList', icon: 'list', permissions: ['manage article'] },
    },
    /** Departments  */
    {
      path: '/departments',
      component: () => import('@/views/departments/List.vue'),
      name: 'departmentList',
      meta: {
        title: 'departmentList',
        icon: 'example',
        permissions: ['view department', 'manage department'],
      },
    },
    /** Grade Level  */
    {
      path: '/grade-level',
      component: () => import('@/views/grade-level/List.vue'),
      name: 'gradeLevelList',
      meta: {
        title: 'gradeLevelList',
        icon: 'tree',
        permissions: ['view gradelevel', 'manage gradelevel'],
      },
    },
    /** Section Level  */
    {
      path: '/sections',
      component: () => import('@/views/section/List.vue'),
      name: 'sectionList',
      meta: {
        title: 'sectionList',
        icon: 'star',
        permissions: ['view section', 'manage section'],
      },
    },
    /** Subject Categories */
    {
      path: 'subject-categories',
      component: () => import('@/views/categories/List'),
      name: 'CategoryList',
      meta: { title: 'categoryList', icon: 'education', permissions: ['view category', 'manage category'] },
    },
    /** Subject Categories */
    {
      path: 'subjects',
      component: () => import('@/views/subjects/List'),
      name: 'subjectList',
      meta: { title: 'subjectList', icon: 'edit', permissions: ['view subject', 'manage subject'] },
    },
    /* Fees */
    {
      path: 'fees/edit/:id(\\d+)',
      component: () => import('@/views/fees/SubFeeList'),
      name: 'ManageFee',
      meta: { title: 'manageFee', noCache: true, permissions: ['manage fee'] },
      hidden: true,
      props: true,
    },
    {
      path: 'fees',
      component: () => import('@/views/fees/List'),
      name: 'FeeList',
      meta: { title: 'feeList', icon: 'tab', permissions: ['manage fee'] },
    },
    /* Payment Mode */
    {
      path: 'payment_mode/edit/:id(\\d+)',
      component: () => import('@/views/payment-mode/PaymentModeType'),
      name: 'ManagePaymentModes',
      meta: { title: 'managePaymentModes', noCache: true, permissions: ['manage fee'] },
      hidden: true,
      props: true,
    },
    {
      path: 'payment_mode',
      component: () => import('@/views/payment-mode/List'),
      name: 'PaymentModeList',
      meta: { title: 'paymentModeList', icon: 'nested', permissions: ['manage fee'] },
    },
  ],
};

export default adminRoutes;
