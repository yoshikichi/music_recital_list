
<from id="form_2">
<div class="form-group">
宛先選択：
<select id="admid_dt" name="admid_dt"  class="form-control" type="text" id="admid_dt" name="admid_dt" >
	<option value="0">選択してください</option>
  @foreach($adminusers as $dt)
    <option value="{{ $dt['id'] }}">{{ $dt['id'] }}|{{ $dt['name'] }}|{{ $dt['email'] }} </option>
  @endforeach
</select>
</div>
<div class="form-group">
宛先名：
<input  class="form-control" type="text" id="name_dt" name="name_dt" value="">
</div>
<div class="form-group">
メール：
<input  class="form-control" type="text" id="emailadr_dt" name="emailadr_dt" value="">  
</div>
<div class="form-group">
件名：
<input  class="form-control" type="text" id="title_dt" name="title_dt" value="【ステラ発表会】他の生徒さまと曲が重なりました。"> 
</div>
<div class="form-group">
本文：
<textarea  class="form-control" id="text_dt" name="text_dt" cols="100" rows="5" >
他の生徒さまと曲が重なりました。
あなたの生徒様に他の方と重なってもよいか聞いてお返事を頂いて下さい。
その内容を教室へメールでご連絡頂いたのちに、先に選んだ方にお問合せして、
先方もＯＫなら、演奏可能となります。
</textarea>
</div>
<div class="form-group">
<input  class="form-control btn btn-success" type="button" id="btnsend2" value="メール送信">
</from>
<div id="result"></div>

<script type="text/javascript">

        $(function(){
            $('#admid_dt').on('change',function(){
				var txtvar = $('#admid_dt option:selected').text();
				var resultArry = txtvar.split('|');
				$('#name_dt').val(resultArry[1]);
				$('#emailadr_dt').val(resultArry[2]);
			});
            // Ajax button click
            $('#btnsend2').on('click',function(){
				if($('#emailadr_dt').val().trim() == ""){
					alert("メールアドレスが指定されていません。");
					return false;
				}
				if(!confirm('送信します。\nよろしいですか？')){
					// キャンセルの処理
					return false; // 処理を終了する
				} else {
					// OKの処理
					$.ajax({
						url:'/recitalplan/mailable/send',
						type:'POST',
						data:{
							'_token': '{{ csrf_token() }}',
							'title_dt':$('#title_dt').val(),
							'admid_dt':$('#admid_dt').val(),
							'name_dt':$('#name_dt').val(),
							'emailadr_dt':$('#emailadr_dt').val(),
							'text_dt':$('#text_dt').val()
						}
					})
					// Ajaxリクエストが成功した時発動
					.done( (data) => {
						$('#result').html('送信済み...');
						console.log(data);
					})
					// Ajaxリクエストが失敗した時発動
					.fail( (data) => {
						$('#result').html('<p style="color:red">送信失敗...</p>');
						console.log(data);
					})
					// Ajaxリクエストが成功・失敗どちらでも発動
					.always( (data) => {

					});
				}
            });
        });

    </script>
    