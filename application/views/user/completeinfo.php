<%extends file="common/base.tpl"%>

<%block name="title"%>填写用户信息<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<%/block%>

<%block name="custom_js"%>
<%/block%>
<%block name="bd"%>
<div id="bd">
<h3>请填写你的信息</h3>
<div id="loginer">
            <form action="javascript:void(0)" method="post" id="register_form">
                <%Form::hidden('csrf_token', Security::token())%>
                <%Form::hidden('goto_f', $goto_f)%>
                <!--<h2 class="regTit overReg">请完善你的个人信息</h2>-->
                <ul class="ul">
                    <li>
                        <div class="tit">电子邮件</div>
                        <div class="formPlace cls">
                            <div class="l"><input type="text" class="text" id="email" name="email" tabindex="1" emel="err-email" value="<%$email|escape:"html"%>"></div>
                            <div class="l tips"><em id="err-email"></em></div>
                        </div>
                    </li>
                    <li>
                        <div class="tit">你的昵称</div>
                        <div class="formPlace cls"><div class="l"><input type="text" class="text" id="honeyname" name="name" tabindex="4" emel="err-honeyname" maxlength="10"<%if isset($nickname)%> value="<%$nickname|escape:"html"%>"<%/if%>></div>
                            <div class="l tips"><em id="err-honeyname"></em></div></div>
                        <div class="tipTxt">该怎么称呼你？昵称不小于1个字符且不大于10个字符，数字、_和- </div>
                    </li>
                    <li>
                        <div class="tit">个性签名</div>
                        <div class="formPlace cls">
                            <textarea rows="4" class="l textara" id="signature" tabindex="5" name="intro" emel="err-intro" maxlength="100"></textarea>
                            <div class="l tips"><em id="err-intro"></em></div>
                        </div>
                    </li>
                </ul>
                <div class="tit">添加兴趣标签有助于获得更符合口味的推荐美食</div>
                <div class="input_tag_wrap">
                    <div class="reg_input_tag">
                        <input type="text" class="text" id="input_tag" name="input_tag" tabindex="3">
                        <span id="submit_tag" ></span>
                    </div>
                    <div class="l tipss"><em id="err-input_tag"></em></div>
                    <div class="tipTxt">标签长度不超过10个字</div>
                    <input type="hidden" name="tags" id="tags"/>
                </div>
                <ul class="ul tag_edit">
                    <li class="cls">
                        <div class="l tag_l">
                            <h3>我已经添加的标签<span class="tipTxt">最多可以添加20个兴趣标签</span></h3>
                            <ul id="owned_tag" class="owned_tag">
                            </ul>
                        </div>
                        <div class="r tag_r">
                            <div class="r_wrap">
                                <h3><a class="r" href="###" id="change_tag">换一换</a>可能感兴趣的标签：</h3>
                                <ul id="guess_tag" class="guess_tag">
                                    <%foreach $select_tags as $strTag%>
                                    <li><a href="###"><%$strTag%></a></li>
                                    <%/foreach%>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <!--下一步按钮-->
                <div class="submiter cls"><button type="button" class="btn btn-reg s-ic-reg"></button></div>
            </form>
        </div>
</div>
<%/block%>

<%block name="foot_js"%>
<%/block%>
