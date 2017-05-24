@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        @include('flash::message')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">发布问题</div>
                    <div class="panel-body">
                        <form action="{{ route('questions.store') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">标题：</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="title" placeholder="标题">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="select2">话题：</label>
                                <select class="myselect2 "  multiple="multiple" id="select2" name="select2[]" style="width:100%;">

                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : ''  }} ">
                                <label for="body">描述：</label>
                                <!-- 编辑器容器 -->
                                <script id="container" name="body" id="body" type="text/plain" >
                                    {!! old('body') !!}
                                </script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('container',{
                toolbars: [
                    ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                ],
                elementPathEnabled: false,
                enableContextMenu: false,
                autoClearEmptyNode:true,
                wordCount:false,
                imagePopup:false,
                autotypeset:{ indent: true,imageBlockLine: 'center' }
            });
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
            });
            $(document).ready(function () {
                function formatTopic (topic) {
                    return "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'>" +
                    topic.name ? topic.name : "Laravel"   +
                        "</div></div></div>";
                }

                function formatTopicSelection (topic) {
                    return topic.name || topic.text;
                }

                $(".myselect2").select2({
                    language: "zh-CN",
                    inputMessage : "请至少输入两个字符开始检索",// 添加默认参数
                    tags: true,
                    placeholder: '选择相关话题',
                    minimumInputLength: 2, //// 最少输入一个字符才开始检索
                    ajax: {
                        url: '/api/topics',
                        dataType: 'json',
                        delay: 250, //延迟时间
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data, params) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    templateResult: formatTopic,//显示的结果集格式
                    templateSelection: formatTopicSelection, //// 列表中选择某一项后显示到文本框的内容
                    escapeMarkup: function (markup) { return markup; },

                });
            });
        </script>
    @endsection

@endsection
