## tp bugs
罗列使用thinkphp框架碰到的bug

1. ```php
   protected $_validate = array(
   array('username','require ','账号名已被使用',1,'unique',1), // 在新增的时候验证name字段是否唯一
   array('email','email','Email 非法'), //todo: 邮箱的唯一性
   ```
   字段自动检查，email字段，检查合法性和唯一性不能同时....
2. ```php+HTML
   <present name="sid">
   sid已经赋值
   </present>
   ```

   show_photo页面，经框架编译后，少了$，报错....

3. 实验二时，relation模型
   ```php
   class AuthorModel extends RelationModel{

       protected $tableName = 'author'; 
       // 关联模型有毒。。
       // protected $_link = array(
       //     'book' => array(
       //         'mapping_type'  => self::HAS_MANY,
       //         'class_name'    => 'book',
       //         'parent_key'    => 'authorid',
       //         'foreign_key'   => 'AuthorId',
       //         'mapping_name'  => 'books',
       //     ),
       // );
   ```








