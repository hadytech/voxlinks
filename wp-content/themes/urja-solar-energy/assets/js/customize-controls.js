( function( api ) {

	// Extends our custom "urja-solar-energy" section.
	api.sectionConstructor['urja-solar-energy'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );