(function ($) {
	tinymce.PluginManager.add( 'rbfi_sc', function ( e, url ){
		var rbfi_mf = null;
		var l10n = wp.media.view.l10n;

		wp.media.view.rbItem = wp.Backbone.View.extend({
			tagName   : 'li',
			role: 'checkbox',
			className : 'rb-item attachment save-ready',

			initialize: function() {
				this.$el.attr('data-name', this.model.get('name'));
			},

			render: function() {
				//this.template = media.template( 'mexp-' + this.options.service.id + '-item-' + this.options.tab );
				this.$el.html( '<div class="attachment-preview js--select-attachment"><i class="flaticon-'+this.model.get('name')+'"></i></div><button type="button" class="button-link check" tabindex="-1"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>' );
				return this;
			}
		});

		wp.media.view.Toolbar.rbfi = wp.media.view.Toolbar.extend({
			initialize: function() {
				_.defaults( this.options, {
					//event : 'inserter',
					close : true,
					items : {
						primary    : {
							id       : 'rbfi-button',
							style    : 'primary',
							text     : this.controller.options.button.text,
							priority : 80,
							click    : function() {
								var selection = this.controller.state().get('sel');
								var names = selection.models.reduce(function(full, current, index){
									return full + (index === 0 ? '' : ',') + current.id;
								}, '');
								//var sc = '[rbfi_flat icon="'+names+'"]';
								var sc = '<span><i class="flaticon-' + names + '"></i>&nbsp;</span>';
								tinyMCE.activeEditor.selection.setContent(sc, { format: 'html' });
								this.controller.state().frame.content.get().clearSelection();
								rbfi_mf.close();
							}
						}
					}
				});
				wp.media.view.Toolbar.prototype.initialize.apply( this, arguments );
			},

			refresh: function() {
				var selection = this.controller.state().get('sel');
				// @TODO i think this is redundant
				this.get( 'primary' ).model.set( 'disabled', !selection.length );
				wp.media.view.Toolbar.prototype.refresh.apply( this, arguments );
			}

		});

		wp.media.view.rbfi = wp.media.View.extend({
			events: {
				'click .rb-item' 					: 'toggleSelection',
				'click .rb-item.selected'	: 'removeSelection',
				'click .button-link.check'	: 'removeSelection',
				'click #rbfi-filter'				: 'renderIcons',
			},

			initialize: function() {
				var _this = this;
				//this.createToolbar();
				//this.clearItems();

				this.model = Backbone.Model.extend({
					name: '',
				});

				var fi_collection = Backbone.Collection.extend({
					model: this.model,
				});

				this.collection = new fi_collection;

				//this.createToolbar();

				this.UpdateCollection();

				//this.collection.on( 'reset', this.renderIcons, this );
				this.renderIcons();
			},

			createToolbar: function( toolbar ) {
				toolbar.view = new wp.media.view.Toolbar({
					controller: this
				});
			},

			toggleSelection: function(e) {
				var _name = e.currentTarget.dataset['name'];
				if (!this.options.controller.options.multiple) {
					this.clearSelection();
				}
				if ( this.getSelection().get( _name ) ) {
					this.removeFromSelection( e.currentTarget, {id: _name} );
				} else {
					this.addToSelection( e.currentTarget, {id: _name} );
				}
				this.views.parent.toolbar.get().refresh();
			},

			removeSelection: function(e) {
				var _name = e.currentTarget.dataset['name'];
				this.removeFromSelection( e.currentTarget, {id: _name} );
			},

			addToSelection: function( target, id ) {
				target.className += ' selected';
				this.getSelection().add( id );
			},

			removeFromSelection: function( target, id ) {
				$(target).removeClass('selected');
				this.getSelection().remove( id );
			},

			clearSelection: function() {
				var ul_parent = $(event.target).closest('.media-frame').find(this.tagName);
				var selection = this.getSelection().models.map(function(model){return model.get('id')});
				selection.forEach(function(_name){
					this.removeFromSelection( $(ul_parent).find('.rb-item[data-name="'+_name+'"]'), {id: _name} );
				}, this);
				this.getSelection().reset();
			},

			getSelection : function() {
				return this.controller.state().get('sel');
			},

			UpdateCollection: function() {
				var items = wp.template('rbfi-icons')().split(',');
				var that = this;
				_.each(items, function(item){
					if (item.length) {
						that.collection.add( [ {name: item} ] );
					}
				});
			},

			renderIcons: function() {
				var filter_input = this.$el.find('#rbfi-filter-item');
				if (filter_input.length === 0 && this.$el.find('li.rb-item').length === 0) {
					var button = new wp.media.view.Button({
						tagName: 'button',
						classes: 'button button-secondary',
						id: 'rbfi-filter',
						text: 'Filter',
						priority: -20,
					}).render();
					this.$el.append( '<div class="search"><input type="text" id="rbfi-filter-item" value="">'+button.el.outerHTML+'</div>' );

					if ( this.collection && this.collection.models.length ) {
						var container = document.createDocumentFragment();
						this.collection.each( function( model ) {
							container.appendChild( this.renderIcon( model ) );
						}, this );
						this.$el.append( container );
					}
				} else {
					this.controller.states.get('library').set('ifilter', filter_input.val() );
					if ( this.collection && this.collection.models.length ) {
						// this == wp.media.view.MediaFrame.Manage
						var filtr = filter_input.val();
						this.collection.each( function( model ) {
							this.updateIcon(this.controller.states.get('library').get('ifilter'), model);
						}, this);
					}
				}
				return this;
			},

			updateIcon: function(filter, model) {
				var _name = model.get('name');
				if (-1 !== _name.indexOf(filter)) {
					this.$el.find('li[data-name="'+_name+'"]').show();
				} else {
					this.$el.find('li[data-name="'+_name+'"]').hide();
				}
			},

			renderIcon: function(model) {
				var view = new wp.media.view.rbItem({
					model : model,
				});
				return view.render().el;
			},
		});

		wp.media.view.MediaFrame.Manage = wp.media.view.MediaFrame.extend({
			initialize: function() {
				wp.media.view.MediaFrame.prototype.initialize.apply( this, arguments );

				_.defaults( this.options, {
					selection: [],
					library:   {},
					multiple:  false,
					state:    'library',
					uploader: false,
				});

				this.states.add([
					new wp.media.controller.Library({
						library:   wp.media.query( this.options.library ),
						multiple:  this.options.multiple,
						title:     this.options.title,
						sel: 	new Backbone.Collection(),
						ifilter: '',
						priority:  20
					})
				]);

				this.on( 'router:create:browse', this.createRouter, this );
				this.on( 'content:render', this.onFrameRender, this);
				this.on( 'open', this.onOpen, this );
				//this.on( 'toolbar:create:select', this.createSelectToolbar, this );
				this.on( 'toolbar:create', this.createToolbar, this );
				this.on( 'selection:toggle', this.onSelect, this );
			},

			createToolbar: function(toolbar) {
				toolbar.view = new wp.media.view.Toolbar.rbfi( {
					controller : this,
					props: new Backbone.Model({id:'props'}),
				} );
			},

			onFrameRender: function(service){
				this.content.set( new wp.media.view.rbfi( {
					service    : service,
					controller : this,
					//model      : this.model,
					tagName:   'ul',
					className  : 'clearfix attachments'
				} ) );
			},

			onOpen: function(contentRegion){
				this.$el.find( '.media-frame-content' ).attr( 'data-columns', '12' );
			},

			createSelectToolbar: function( toolbar, options ) {
				options = options || this.options.button || {};
				options.controller = this;

				toolbar.view = new wp.media.view.Toolbar.Select( options );
			}
		});

		e.addButton( 'rbfi_icon', {
				title: 'CWS Flaticon',
				icon: 'rbfi-icon',
				onclick: function () {
					if (!rbfi_mf) {
						rbfi_mf = wp.media({
							title : 'Title',
							multiple : false,
							filters : true,
							search: true,
							frame : 'manage',
							library : {type: 'rbfi-icons'},
							//library : {type: 'image'},
							button : { text : 'Insert Flaticon' }
						});
					}
					rbfi_mf.open();
				},
			});
	});

}(jQuery));