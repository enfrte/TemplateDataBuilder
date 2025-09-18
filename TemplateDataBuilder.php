<?php

// namespace ;

// use Lang;

/**
 * Class to build and transform associative arrays with locale support in case formatting differes.
 */
class TemplateDataBuilder
{
	const SUPPORTED_LOCALS = ['fi', 'en', 'se', 'de'];

	/**
	 * @var array
	 */
	protected $data = [];

	/**
	 * @var string
	 */
	protected $locale = '';

	/**
	 * @var string
	 */
	protected $fallBackLocale = 'fi';


	/**
	 * @param string $locale
	 */
	public function __construct(string $locale = '') {
		$this->setLocale($locale);
	}


	/**
	 * Get the transformed data
	 *
	 * @return array
	 */
	public function get(): array
	{
		return $this->data;
	}


	/**
	 * Sets source the data to be transformed
	 *
	 * @param array $data
	 * @return self
	 */
	public function setData(array $data): self
	{
		$this->data = $data;
		return $this;
	}


	/**
	 * Sets the locale for when formatting is locale specific
	 *
	 * @param string $locale
	 * @return void
	 */
	protected function setLocale(string $locale): void
	{
		$this->locale = $this->fallBackLocale;

		if ( in_array($locale, self::SUPPORTED_LOCALS) ) {
			$this->locale = $locale;
		}
	}


	/**
	 * Concatenate names in order provided
	 *
	 * @param string $newKey
	 * @param string $order1
	 * @param string $order2
	 * @param boolean $comma
	 * @return self
	 */
	public function concatNames(string $newKey, string $order1 = '', string $order2 = '', $comma = true): self
	{
		$order1 = $this->data[$order1] ?? '';
		$order2 = $this->data[$order2] ?? '';
		$this->data[$newKey] = $order1 . ($comma ? ', ' : ' ') . $order2;
		return $this;
	}


	/**
	 * Concatenate address fields
	 *
	 * @param string $newKey
	 * @param string $street
	 * @param string $postcode
	 * @param string $post_town
	 * @return self
	 */
	public function concatAddress(string $newKey, string $street, string $postcode, string $post_town): self
	{
		$street = $this->data[$street] ?? '';
		$postcode = $this->data[$postcode] ?? '';
		$post_town = $this->data[$post_town] ?? '';
		$this->data[$newKey] = implode(', ', array_filter([$street, $postcode, $post_town]));
		return $this;
	}


	/**
	 * Add title based on gender field (Mr. Mrs./Ms.) - Sets localised string
	 * 
	 *
	 * @param string $newKey
	 * @param array $keys - Pass the correct values for male and female if defaults are not correct.
	 * @return self
	 */
	public function title(string $newKey, mixed $gender, array $genderKeys = [ 1 => 'male', 2 => 'female']): self
	{
		$genderValue = $this->data[$gender];

		if ( $genderValue === '' || is_null($genderValue) || !array_key_exists($genderValue, $genderKeys)) {
			$this->data[$newKey] = '';
			return $this;
		} 

		$title = '';

		if ( $genderKeys[$genderValue] === 'male' ) {
			$title = 'MR_ABB'; // Replace with Lang::get('MR_ABB');
		}
		elseif ( $genderKeys[$genderValue] === 'female' ) {
			$title = 'MRS_MS_ABB'; // Replace with Lang::get('MRS_MS_ABB');
		}

		$this->data[$newKey] = $title;
		return $this;
	}

	/**
	 * Keep on truckin...
	 */

}
