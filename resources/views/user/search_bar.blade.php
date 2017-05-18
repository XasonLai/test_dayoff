<div class="row">

{!! Form::open([ 'method' => 'get', 'url' => $url,
                'class' => 'size_t3',
                'id' => 'form-saerch', 'name' => 'search']) !!}
  <div class="col-lg-offset-1 col-lg-10">
    <div class="input-group">
      {!! Form::text('keyword', isset($keyword) ? $keyword : '', ["class"=>"form-control",'placeholder'=>'請輸入']) !!}
      <span class="input-group-btn">
        <button class="btn btn-info btn-search" type="submit"> 送出 </button>
      </span>
    </div>
  </div>
{!! Form::close() !!}
</div>

@section('footer_af')
@parent
<script>
(function($){
  $(function(){
    $('#form-saerch').submit(function(){
      var name_f = $('[name="keyword"]');
      var keyword = '';
      if($.trim(name_f.val()) == '') {
        return false;
      }
      keyword = $.trim(name_f.val());
      name_f.prop( "disabled", true );
      window.location.href = $(this).attr('action') + '/' + keyword;
      return false;
    });
  });
})(jQuery);
</script>
@endsection
