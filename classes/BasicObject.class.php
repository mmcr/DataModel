<?

/**
 * BasicObject class
 * 
 * This abstract base class exists only to provide the ability to create objects with default values.
 * It is the parent class for DataModel, though DataModel itself does not use this functionality
 * 
 * @author Matthew Roberts
 * @see DataModel
 */
	class BasicObject {
		
/**
 * Contains the array of default values
 * 
 * @var array Associate array mapping object properties to default values
 */
		var $defaultPropertyValues;
		
/**
 * BasicObject constructor
 * 
 * Sets defaultPropertyValues to an empty array
 *
 * @return BasicObject
 */
		public function __construct() {
			$this->defaultPropertyValues = array();
		}
		
		
/**
 * setWithDefaults
 * 
 * Loops through each property of the object, checking to see if the paramter array contains an entry for it.
 * If so, set the object's value to the paramter. Otherwise, set it to the default.
 *
 * @param array Associate array of keys/values to set for the object
 */
		public function setWithDefaults($o = null) {
			global $_STATUS;
			if (count($this->defaultPropertyValues) > 0) {

				foreach ($this as $key => $v) {
					if (substr($key, 0 , 1) == "_") {
						$k = substr($key, 1);
						
						if (isset($o[$k]) || isset($this->defaultPropertyValues[$k])) {
							setWithDefault($this->$key, $o[$k], $this->defaultPropertyValues[$k]);
						}
					}
				}
			
			}
		}	
		
/**
 * valueByObjString
 * 
 * Takes a pseudo-xpath style string and executes it off of the current object.
 * Example: $myBasicObject->valueByObjString("functionReturningSubObject()->aVariable");
 *
 * @deprecated DataModel provides a better version of this function that accepts parameters within called functions
 * @param string parameter/function to retrieve
 * @return mixed
 */
		public function valueByObjString($string) {
			$string = str_replace("$", "", $string);
			$varParts = explode("->", $string);
			$obj = $this;
			foreach ($varParts as $v) {
				if (strpos($v, "(")) {
					list($v, $foo) = explode("(", $v);				
					$obj = $obj->$v();
				} else {
					$obj = $obj->$v;				
				}
			}
			return $obj;
		
		}
	}



?>