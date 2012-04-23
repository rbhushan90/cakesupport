<?php
class User extends AppModel {
  public $name = 'User';

  public $hasOne = array(
    'UserMetadata' => array(
      'className' => 'UserMetadata'
    )
  );

  public $hasMany = array(
    'UserQuestion' => array(
      'className' => 'Question',
      'order' => 'UserQuestion.created DESC',
      'dependent' => true
    ),

    'UserAnswer' => array(
      'className' => 'Answer',
      'order' => 'UserAnswer.created DESC',
      'dependent' => true
    ),

    'UserComment' => array(
      'className' => 'Comment',
      'order' => 'UserComment.created DESC',
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
        ),
        'unique' => array(
          'rule' => 'isUnique',
          'message' => 'This username is already taken'
        )
      ),
      'password' => array(
        'rule' => array('minLength', '8'),
        'message' => 'Must be at least 8 characters long',
      ),
      'email' => array(
        'format' => array(
          'rule' => 'email',
          'message' => 'Must provide a valid email address'
        ),
        'unique' => array(
          'rule' => 'isUnique',
          'message' => 'That email address is already in user'
        )
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

}
?>
