@include('standards/head')
@include('sidebar')
@include('topbar')
@include('inc/messages')
<body class="addComment-body">
  <div class="row pl-4" >
    <div class="col">
      <a href="/{{$lessonId}}/show" name="button" class="custom-link"><span class="fa fa-caret-left"></span> zurück</a>    
    </div>
  </div>

  <div class="row pl-4">
    <div class="col-6">
      <h4>Vorschau</h4>
    </div>
    <div class="col-6 pl-0">
      <h4>Kommentare</h4>
    </div>
  </div>
  
  <div class="row pl-4">
    <div class="col-6">
      <div class="row">
        @if($fileToShow->extension != 'pdf' && $fileToShow->extension != 'txt')
          <div style="height: 500px; width: 500px;">
            <p>keine Vorschau</p>
          </div>
        @else
          <iframe src="http://fundus.localhost/.{{$fileToShow->path}}" class="custom-frame rounded-sm" height="500px" width="500px"></iframe>
        @endif 
      </div>  
      <div class="row">
        <div class="col-2">
          Bewertung
        </div>

        <div class="col-2">
          {{$rating}}
        </div>
        
        <div class="col-3">
          <a href="/{{$lessonId}}/{{$fileToShow->id}}/add/comment/up">hier upvoten</a>
        </div>

        <div class="col-3">
          <a href="/{{$lessonId}}/{{$fileToShow->id}}/add/comment/down">hier downvoten</a>
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="row mb-1 scrollable rounded-sm">
        <ul class="noStyle">
          @foreach($comments as $comment)
            <li class="mb-2">
              <div class="col-12 mb-2">
                  @foreach($users as $user)
                    @if($comment->userid == $user->id)
                      <div class="row">
                        <table>
                          <tr>
                            <td width="35px">
                              <div class="image">
                                @if(!empty($user->imageURL))
                                    <img src="{{$user->imageURL}}" alt="Profilbild" class="img-circle" style="width: 25px; height: 25px;"/>
                                @else
                                    <img src="https://i.pinimg.com/236x/8b/33/47/8b3347691677254b345de63fe82f8ef6--batman.jpg" style="width: 25px; height: 25px;" class="img-circle" alt="Profilbild"/>
                                @endif
                              </div>
                            </td>
                            
                            <td class="align-bottom">
                              <div class="">
                              <small>{{$user->coursename}} | {{$user->username}}</small>
                              </div> 
                            </td>
                          </tr>  

                          <tr>
                            <td colspan="2">{{$comment->content}} </td>
                          </tr>
                        </table>
                      </div>
                    @endif
                  @endforeach
              </div>
            <hr class="hr-custom">
            </li>
          @endforeach
        </ul>
      </div>
        <div class="row">
        <form class="" action="/{{$lessonId}}/{{$fileToShow->id}}/add/comment/store" method="post">
          <div class="input-group-append">
            <input class="form-control" type="text" name="content" placeholder="dein Kommentar" style="width: 290px; margin-right: 10px;">
            <span class="input-group-btn">
              <button class="btn btn-red btn-sm-custom" type="submit" name="" value="">abschicken</button>
            </span>
          </div>
          @csrf
        </form>
      </div>
    </div>
  </div>
</body>

