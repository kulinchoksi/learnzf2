<?php
namespace User\Form;

Use Zend\Form\Form;
Use Zend\InputFilter\InputFilter;
Use Zend\InputFilter\InputFilterInterface;
Use Zend\InputFilter\Factory as InputFactory;

class User extends Form
{
    public function __construct($name='user')
    {
        parent::__construct($name);
        
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'email', // unique element name in the form, <input name=".."
            'type' => 'Zend\Form\Element\Email', // must be valid Zend Form Element, can also use short name as 'email'
            'options' => array(
                'label' => 'Email:',
            ),
            'attributes' => array( // attributes are passed directly to the html element
                'type' => 'email', // <input type="email"
                'required' => 'required', // html5 attribute
                'placeholder' => 'Email Address...',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Password:',
            ),
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'placeholder' => 'Password here...',
            ),
        ));
        
        $this->add(array(
            'name' => 'password_verify',
            'type' => 'Zend\Form\Element\Password',
            'options' => array(
                'label' => 'Verify Password:',
            ),
            'attributes' => array(
                'type' => 'password',
                'required' => 'required',
                'placeholder' => 'Verify Password here...',
            ),
        ));
        
        $this->add(array(
            'name' => 'name',
            'type' => 'Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Name:',
            ),
            'attributes' => array(
                'type' => 'text',
                'required' => 'required',
                'placeholder' => 'Type name...',
            ),
        ));
        
        $this->add(array(
            'name' => 'phone',
            'options' => array(
                'label' => 'Phone number:',
            ),
            'attributes' => array(
                'type' => 'tel',
                'required' => 'required',
                'pattern' => '^[\d-/]+$' // specify allowed characters in HTML5
            ),
        ));
        
        $this->add(array(
            'name' => 'photo',
            'type' => 'Zend\Form\Element\File',
            'options' => array(
                'label' => 'Your photo:',
            ),
            'attributes' => array(
                'id' => 'photo',
                // 'required' => 'required',
            ),
        ));
        
        // special code (CSRF) to protect form being submitted from automated scripts
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
            'options' => array(
                'label' => '' // to avoid zend trying translating null label
            ),
        ));
        
        // submit button
        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                // 'type' => 'submit',
                'required' => 'false', // ??
                'value' => 'Submit',
            ),
        ));
    }
    
    public function getInputFilter()
    {
        if (!$this->filter) {
            $inputFilter = new InputFilter();
            $inputFactory = new InputFactory();
            
            // email filter and validator
            $inputFilter->add($inputFactory->createInput(array(
                'name' => 'email',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'messages' => array(
                                'emailAddressInvalidFormat' => 'Email address format is not valid'
                            )
                        ),
                    ),
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Email address is required'
                            )
                        )
                    ),
                ),
            )));
            
            // name filter and validator
            $inputFilter->add($inputFactory->createInput(array(
                'name' => 'name',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Name is required'
                            )
                        )
                    )
                )
            )));
            
            // password filter and validation
            $inputFilter->add($inputFactory->createInput(array(
                'name' => 'password',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Password is required'
                            )
                        )
                    )
                )
            )));
            
            // verify password filter and validation
            $inputFilter->add($inputFactory->createInput(array(
                'name' => 'password_verify',
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password',
                            'messages' => array(
                                'notSame' => 'Passwords do not match',
                            ),
                        )
                    )
                )
            )));
            
            // photo with image type and size validations
            $inputFilter->add($inputFactory->createInput(array(
                'name' => 'photo',
                'validators' => array(
                    array(
                        'name' => 'filesize',
                        'options' => array(
                            'max' => '2097152', // 2 MB
                        ),
                    ),
                    array(
                        'name' => 'filemimetype',
                        'options' => array(
                            'mimeType' => 'image/png,image/x-png,image/jpg,image/jpeg,image/gif'
                        ),
                    ),
                    array(
                        'name' => 'fileimagesize',
                        'options' => array(
                            'maxWidth' => 200,
                            'maxHeight' => 200
                        )
                    ),
                ),
                'filters' => array(
                    // the filter below will save the uploaded file under
                    // <app-path>/data/image/photos/<tmp-name>_<random-data>
                    array(
                        'name' => 'filerenameupload',
                        'options' => array(
                            // Notice: make sure that following folder exists on system
                            // otherwise this filter will not pass and you will get strange
                            // error message reporting that required field is empty
                            'target' => 'data/image/photos/',
                            'randomize' => true,
                        ),
                    ),
                ),
            )));

            // phone filter and validation
            $inputFilter->add($inputFactory->createInput(array(
                'name' => 'phone',
                'filters' => array(
                    array('name' => 'digits'),
                    array('name' => 'stringtrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'regex',
                        'options' => array(
                            'pattern' => '/^[\d-\/]+$/',
                        )
                    )
                )
            )));
            
            $this->filter = $inputFilter;
        }
        
        return $this->filter;
    }
    
    // to prohibit changes to form's input filter
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("It's not allowed to set input filter");
    }
}
