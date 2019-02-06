<?php
/**
 * Abstract collection class for use with terms.
 *
 * @package wpscholar\WordPress
 */

namespace wpscholar\WordPress;

/**
 * Class TermCollectionBase
 *
 * @package wpscholar\WordPress
 */
class TermCollectionBase extends CollectionBase {

	/**
	 * Taxonomy name
	 *
	 * @var string
	 */
	const TAXONOMY = null;

	/**
	 * Fetch items
	 *
	 * @param array|string $args Query arguments
	 */
	public function fetch( $args = [] ) {

		$args = wp_parse_args( $args );

		$items = [];

		$query_args = array_merge(
			$this->default_args,
			$args,
			array_merge(
				[
					'fields'   => 'ids',
					'taxonomy' => static::TAXONOMY,
				],
				$this->required_args
			)
		);

		$query = new \WP_Term_Query( $query_args );

		if ( $query->terms ) {
			$items = $query->terms;
		}

		$this->populate( $items );
	}

	/**
	 * Get the found objects
	 */
	public function objects() {
		return $this->collection()->map( 'get_term' );
	}

	/**
	 * Transform ID into a term object.
	 *
	 * @param int $id Term ID
	 *
	 * @return \WP_Term
	 */
	protected function transform( $id ) {
		return get_term( $id );
	}

}
