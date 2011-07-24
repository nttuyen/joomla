<?php
/**
 * ShoppingBasket
 *
 * A simple shopping basket class used to add and delete items 
 * from a session based shopping cart
 * @package ShoppingBasket
 * @access public
 */
class ShoppingBasket {

	public static $COOKIE_NAME = 'jnt_shopping_basket';
	
	public static $COOKIE_EXPIRE = 86400; // One day
	
	public static $SESSION_KEY = 'session.shopping_cart';
	
	protected $_session;

	/**
	 * ShoppingBasket::__construct()
	 *
	 * Construct function. Parses cookie if set.
	 * @return
	 */
	function __construct() {
		//init var
		$this->_session = JFactory::getSession();
	}

	/**
	 * ShoppingBasket::addToBasket()
	 *
	 * Adds item to basket. If $id already exists in array then qty updated
	 * @param mixed $id - ID of item
	 * @param mixed $params - Qty of items to be added to cart
	 * @return bool
	 */
	function addToBasket($id, $params = 1) {
		$cart = $this->_session->get(self::$SESSION_KEY);
		if(!$cart) $cart = array();
		
		if(isset($cart[$id]))
			return true;
		else 
			$cart[$id] = $params;
		
		$this->_session->set(self::$SESSION_KEY, $cart);
		
		return true;
	}

	/**
	 * ShoppingBasket::removeFromBasket()
	 *
	 * Removes item from basket. If final qty less than 1 then item deleted.
	 * @param mixed $id - Id of item
	 * @param mixed $params - Qty of items to be removed to cart
	 * @see DeleteFromBasket()
	 * @return bool
	 */
	function removeFromBasket($id, $param = 1) {
		$cart = $this->_session->get(self::$SESSION_KEY);
		
		if (isset($cart[$id])) {			
			return $this->deleteFromBasket($id);
		}
		
		//$this->_session->set(self::$SESSION_KEY, $cart);
		
		return true;
	}

	/**
	 * ShoppingBasket::deleteFromBasket()
	 *
	 * Completely removes item from basket
	 * @param mixed $id
	 * @return bool
	 */
	function deleteFromBasket($id)
	{
		$cart = $this->_session->get(self::$SESSION_KEY);
		unset($cart[$id]);
		
		$this->_session->set(self::$SESSION_KEY, $cart);
		
		//$this->setCookie();
		return true;
	}

	/**
	 * ShoppingBasket::getBasket()
	 *
	 * Returns the basket session as an array of item => qty
	 * @return array $itemArray
	 */
	function getBasket() {
		$cart = $this->_session->get(self::$SESSION_KEY);
		
		if (isset($cart) && !empty($cart)) {
			foreach ($cart as $k => $v) {
				$itemArray[$k] = $v;
			}
			
			return $itemArray;
		} else {
			return false;
		}
	}

	/**
	 * ShoppingBasket::updateBasket()
	 *
	 * Updates a basket item with a specific qty
	 * @param mixed $id - ID of item
	 * @param mixed $qty - Qty of items in basket
	 * @return bool
	 */
	function updateBasket($id, $params = 1) 
	{

		//$qty = (is_numeric($qty)) ? (int)$qty : 0;
		
		$cart = $this->_session->get(self::$SESSION_KEY);

		if (isset($cart[$id])) {
			$cart[$id] = $qty;
			
			$this->_session->set(self::$SESSION_KEY, $cart);
			
			//$this->setCookie();
			return true;

		} else {
			return false;
		}

	}

	/**
	 * ShoppingBasket::getBasketQty()
	 *
	 * Returns the total amount of items in the basket
	 * @return int quantity of items in basket
	 */
	function getBasketQty() {
		$cart = $this->_session->get(self::$SESSION_KEY);
		
		if (isset($cart)) 
		{
			$qty = 0;
			foreach ($cart as $item) {
				if(is_numeric($item)) {
					$qty += (int)$item;
				}else if(is_array($item)) {
					$qty += $item['qty'];
				} else if(isset($item->qty)) {
					$qty += $item->qty;
				}
			}
			return $qty;
		} else {
			return 0;
		}
	}

	/**
	 * ShoppingBasket::emptyBasket()
	 *
	 * Completely removes the basket session
	 * @return
	 */
	function emptyBasket() {
		$this->_session->set(self::$SESSION_KEY, null);
		return true;
	}

	/**
	 * ShoppingBasket::setCookie()
	 *
	 * Creates cookie of basket items
	 * @return bool
	 */
	function setCookie() {

		if ($this->saveCookie) {
			$string = base64_encode(serialize($_SESSION['cart']));
			setcookie($this->cookieName, $string, time() + $this->cookieExpire, '/');
			return true;
		}
		 
		return false;
	}
	 
	/**
	 * ShoppingBasket::saveCookie()
	 *
	 * Sets save cookie option
	 * @param bool $bool
	 * @return bool
	 */
	function saveCookie($bool = TRUE) {
		$this->saveCookie = $bool;
		return true;
	}

}
