<?php

/**
 * Description of ModelNameBehaviour
 *
 * @author careddum
 */
class ModelNameBehavior extends CModelBehavior {
    
    public function getOwnerName() {
        return get_class($this->owner);
    }
    
    public function getModelName() {
        return Yii::t(strtolower($this->ownerName), $this->ownerName);
    }
    
    public function getModelPluralName() {
        return Yii::t(strtolower($this->ownerName), $this->pluralize($this->ownerName));
    }
    
    /**
	 * Converts a word to its plural form.
	 * Note that this is for English only!
	 * For example, 'apple' will become 'apples', and 'child' will become 'children'.
	 * @param string $name the word to be pluralized
	 * @return string the pluralized word
	 */
	private function pluralize($name)
	{
		$rules=array(
			'/(m)ove$/i' => '\1oves',
			'/(f)oot$/i' => '\1eet',
			'/(c)hild$/i' => '\1hildren',
			'/(h)uman$/i' => '\1umans',
			'/(m)an$/i' => '\1en',
			'/(t)ooth$/i' => '\1eeth',
			'/(p)erson$/i' => '\1eople',
			'/([m|l])ouse$/i' => '\1ice',
			'/(x|ch|ss|sh|us|as|is|os)$/i' => '\1es',
			'/([^aeiouy]|qu)y$/i' => '\1ies',
			'/(?:([^f])fe|([lr])f)$/i' => '\1\2ves',
			'/(shea|lea|loa|thie)f$/i' => '\1ves',
			'/([ti])um$/i' => '\1a',
			'/(tomat|potat|ech|her|vet)o$/i' => '\1oes',
			'/(bu)s$/i' => '\1ses',
			'/(ax|test)is$/i' => '\1es',
			'/s$/' => 's',
		);
		foreach($rules as $rule=>$replacement)
		{
			if(preg_match($rule,$name))
				return preg_replace($rule,$replacement,$name);
		}
		return $name.'s';
	}
 
    
}

?>
