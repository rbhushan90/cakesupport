<?php
class User extends AppModel {
  public $name = 'User';

  public $hasMany = array(
    'UserAnswer' => array(
      'className' => 'Answer',
      'foreignKey' => 'user_id',
      'order' => 'UserAnswer.created DESC',
      'dependent' => true
    )
  );

  public $validate = array(
      'username' => array(
        'alphaNumeric' => array(
          'rule' => 'alphaNumeric',
          'required' => 'true',
          'message' => 'Alpha-Numeric characters only'
        ),
        'between' => array(
          'rule' => array('between', 1, 20),
          'required' => 'true',
          'message' => 'Between 1 and 20 characters long'
        ) 
      ),
      'password' => array(
        'rule' => array('minLength', '1'),
        'message' => 'Must be at least 1 character long',
      ),
      'email' => array(
        'rule' => 'email',
        'message' => 'Must provide a valid email address'
      ),
      'first_name' => array(
        'rule' => 'notEmpty',
        'message' => 'Cannot be left blank'
      ),
      'last_name' => array(
        'rule' => 'notEmpty',
        'message' => 'Cannot be left blank'
      )
    );

  public static $permissionMasks = array(
    'canAcceptAnswers' => 1,
    'canAddFAQ' => 1,
    'canDeleteFAQ' => 1,
    'canDeleteAnswers' => 2,
    'canEditAnyQuestion' => 2,
    'canDeleteAnyQuestion' => 2,
    'postBlog' => 4,
  );
}
?>
