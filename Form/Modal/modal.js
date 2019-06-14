function Modal(options){
	this.modal = $('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">\
                  <div class="modal-dialog">\
                        <div class="modal-content">\
                              <div class="modal-header flex-row-start-center">\
                                <h4 class="modal-title text-white upper-case" id="title"></h4>\
                                <button id="close" class="close" data-dismiss="modal" aria-label="Close">\
                                	<i class="fa fa-times text-white"></i>\
                               	</button>\
                              </div>\
                              <div class="modal-body"></div>\
                              <div class="modal-footer">\
                                <button id="no" class="btn btn-default" data-dismiss="modal">NO</button>\
                                <button id="si" class="btn btn-danger">SI</button>\
                              </div>\
                        </div>\
                      </div>\
                </div>')
  this.bg = (options.bg != null) ? options.bg : 'bg-secondary'
  this.title = (options.title != null) ? options.title : 'Titulo'
  this.size = (options.size != null) ? options.size : 'sm'
  this.classSize = 'md'
  this.callBack = (options.callBack != null) ? options.callBack : null
  this.modal.find('.modal-header').addClass(this.bg)
	this.modal.find('#title').html(this.title)
	switch(this.size){
    case 'small': this.classSize = 'modal-sm'; break;
    case 'medium': this.classSize = 'modal-xl'; break;
    case 'big': this.classSize = 'modal-lg'; break;
  }
  this.modal.find('.modal-dialog').addClass(this.classSize)
  this.modal.find('.modal-footer').hide()
	this.modal.find('#no').click(function(){
		$(this).closest('.modal').modal('hide')
		
	})

	this.modal.find('#si').data('exe', this.callBack).click(function(){
		var callBack = $(this).data('exe')
		try{
			window[callBack($(this).closest('.modal'))].call
		}catch(e){}

	})

  this.openModal = function(url){
      this.modal.find('.modal-body').load(url)
      this.modal.modal('show')
  }

	$('body').append(this.modal)
	

}


// uso

// myModal = new Modal({
//   title: 'Titulo',
//   size: 'small/medium/big'
// })
                                       
// call
// myModal.openModal(url)