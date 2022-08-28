const f_clientFormCreateStr = `<form class="f_clientForm" action="#" method="post" onsubmit = "return checkForEmptyF();"> 
                                <fieldset class="f_privateInfo">
                                    <legend>Личные данные</legend>
                                    <label>
                                        <input maxlength="50" class="f_SURNAME" name="f_SURNAME" />
                                        Фамилия
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_NAME" name="f_NAME" />
                                        Имя
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_MIDDLE" name="f_MIDDLE" />
                                        Отчество
                                    </label>
                                    <label>
                                        <input type="date" class="f_BIRTHDAY" name="f_BIRTHDAY" />
                                        Дата рождения
                                    </label>
                                </fieldset>
                                <fieldset class="f_passportInfo">
                                    <legend>Паспортные данные</legend>
                                    <label>
                                        <input type="number" class="f_PASSER" name="f_PASSER" max="999999" title="Введите серию паспорта" />
                                        Серия
                                    </label>
                                    <label>
                                        <input type="number" class="f_PASNUM" name="f_PASNUM" max="999999" title="Введите номер паспорта" />
                                        Номер
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_ISBYWHOM" name="f_ISBYWHOM" title="Введите кем выдан" />
                                        Кем выдан
                                    </label>                                    
                                    <label>
                                        <input maxlength="50" class="f_PASCODE" name="f_PASCODE" title="Введите код подразделения" />
                                        Код подразделения
                                    </label>
                                    <label>
                                        <input type="date" class="f_WHENIS" name="f_WHENIS" title="Введите когда выдан" />
                                        Когда выдан
                                    </label>
                                </fieldset>
                                <fieldset class="f_contactInfo">
                                    <legend>Контактные данные</legend>
                                    <label>
                                        <input maxlength="50" class="f_TELW" name="f_TELW" title="Введите телефон рабочий" />
                                        Телефон раб.
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_TELM" name="f_TELM" title="Введите телефон мобильный" />
                                        Телефон моб.
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_EMAIL" name="f_EMAIL" title="Введите адрес эл. почты" />
                                        Адрес эл. почты
                                    </label>
                                    <label>
                                        <input type="number" class="f_IND" name="f_IND" max="999999" title="Введите индекс" />
                                        Индекс
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_CITY" name="f_CITY" title="Введите город" />
                                        Город
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_STREET" name="f_STREET" title="Введите улицу" />
                                        Улица
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_BLD" name="f_BLD" title="Введите дом" />
                                        Дом
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_CORP" name="f_CORP" title="Введите корпус" />
                                        Корпус
                                    </label>
                                    <label>
                                        <input maxlength="50" class="f_FLAT" name="f_FLAT" title="Введите квартиру" />
                                        Квартира
                                    </label>
                                </fieldset> 
                                <fieldset class="f_notesInput"> 
                                    <legend>Заметки</legend>                                                     
                                    <textarea name="f_NOTES" class="f_NOTES" cols="50" rows="10" title="Введите заметки"></textarea>                                                                                          
                                </fieldset> 
                                <div class="f_buttonsInput">
                                    <input type="submit" class="f_btn-submit btn" name="submitInput-fizClient" value="Сохранить" />                                     
                                    <button class="f_btn-reset btn" name="resetInputF" onClick="window.location.href='clients.php?selCl=fizClient';">"Отмена"</button>                                    
                                </div>
                                </form>`;

const y_clientFormCreateStr = `<form class="y_clientForm" action="#" method="post" onsubmit = "return checkForEmptyY();"> 
                                <fieldset class="y_organizationInfo">
                                    <legend>Данные организации</legend>
                                    <label>
                                        <input maxlength="50" class="y_OPF" name="y_OPF" />
                                        Орг.-правовая форма
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_COMPANY" name="y_COMPANY" />
                                        Наименование
                                    </label>
                                    <label>
                                        <input type="number" class="y_OGRN" name="y_OGRN" max="999999" title="Введите ОГРН организации" />
                                        ОГРН
                                    </label>
                                    <label>
                                        <input type="number" class="y_INN" name="y_INN" max="999999" title="Введите ИНН организации" />
                                        ИНН
                                    </label> 
                                </fieldset>   
                                <fieldset class="y_adressInfo">
                                    <legend>Юридический адрес</legend>
                                    <label>
                                        <input type="number" class="y_IND" name="y_IND" max="999999" title="Введите индекс" />
                                        Индекс
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_CITY "name="y_CITY" title="Введите город" />
                                        Город
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_STREET" name="y_STREET" title="Введите улицу" />
                                        Улица
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_BLD" name="y_BLD" title="Введите дом" />
                                        Дом
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_CORP" name="y_CORP" title="Введите корпус" />
                                        Корпус
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_ROOM" name="y_ROOM" title="Введите помещение" />
                                        Помещение
                                    </label>
                                </fieldset>
                                <fieldset class="y_contactInfo">
                                    <legend>Контактные данные</legend>
                                    <label>
                                        <input maxlength="50" class="y_TEL" name="y_TEL" title="Введите номер телефона" />
                                        Телефон
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_EMAIL" name="y_EMAIL" title="Введите адрес эл. почты" />
                                        Адрес эл. почты
                                    </label>
                                </fieldset>
                                <fieldset class="y_delegateInfo">
                                    <legend>Сведения о представителе</legend>
                                    <div class="y_ontDelInfo">
                                        <label>
                                            <input maxlength="50" class="y_SURDEL" name="y_SURDEL" title="Введите фамилию" />
                                            Фамилия
                                        </label>
                                        <label>
                                            <input maxlength="50" class="y_NAMEDEL" name="y_NAMEDEL" title="Введите имя" />
                                            Имя
                                        </label>
                                        <label>
                                            <input maxlength="50" class="y_MIDDEL" name="y_MIDDEL" title="Введите отчество" />
                                            Отчество
                                        </label>
                                        <label>
                                            <input maxlength="50" class="y_DELEGATE" name="y_DELEGATE" title="Введите должность" />
                                            Должность
                                        </label>
                                    </div>
                                    <div class="y_docDelInfo">
                                        <fieldset class="y_docInfo">
                                            <legend>Доверенность или иной документ</legend>
                                            <label>
                                                <input maxlength="50" class="y_DOC" name="y_DOC" title="Введите наименование документа" />
                                                Наименование
                                            </label>
                                            <label>
                                                <input maxlength="50" class="y_REQS" name="y_REQS" title="Введите реквизиты документа" />
                                                Реквизиты
                                            </label>
                                        </fieldset>
                                    </div>
                                </fieldset>
                                <fieldset class="y_bossInfo">
                                    <legend>Руководитель</legend>
                                    <label>
                                        <input maxlength="50" class="y_BSURNAME" name="y_BSURNAME" title="Введите фамилию" />
                                        Фамилия
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_BNAME" name="y_BNAME" title="Введите имя" />
                                        Имя
                                    </label>
                                    <label>
                                        <input maxlength="50" class="y_BMIDDLE" name="y_BMIDDLE" title="Введите отчество" />
                                        Отчество
                                    </label>
                                </fieldset>
                                <fieldset class="y_notesInput"> 
                                    <legend>Заметки</legend>                                                     
                                    <textarea name="y_NOTES" class="y_NOTES" cols="30" rows="10" title="Введите заметки"></textarea>                                                                                          
                                </fieldset> 
                                <div class="y_buttonsInput">
                                    <input type="submit" class="y_btn-submit btn" name="submitInput-yurClient" value="Сохранить" />
                                    <button class="y_btn-reset btn" name="resetInputY" onClick="window.location.href='clients.php?selCl=yurClient';">"Отмена"</button>                                    
                                </div>
                            </form>`;
                            
const caseFormCreateStr = `<div class="main_cont_case">
                            <form action="" class="case_form" method="post">
                                <fieldset class="cont_main_info_case"> 
                                    <span class="span_inner case_exist">Новое дело</span>
                                    <fieldset class="cont_id_name_client_select">
                                        <legend>Клиент</legend> 
                                        <select name="id_name_client_select" class="id_name_client_select" onchange="onCatClChange(this)">
                                        </select>
                                    </fieldset>
                                    <span class="span_inner cat_client_text">Физическое лицо</span>
                                    <fieldset class="cont_CLIENTSTATUS">
                                        <legend>Статус клиента</legend>
                                        <select name="CLIENTSTATUS" class="CLIENTSTATUS">
                                            <option value="1" selected="checked">истец</option>
                                            <option value="2">ответчик</option>
                                            <option value="3">третье лицо</option>
                                            <option value="4">обвиняемый</option>
                                            <option value="5">потерпевший</option>
                                            <option value="6">привл. к админ. отв.</option>
                                            <option value="7">админ. истец</option>
                                            <option value="8">иное</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="cont_CASECAT">
                                        <legend>Категория дела</legend>
                                        <select name="CASECAT" class="CASECAT">
                                            <option value="1" selected="checked">гражданское</option>
                                            <option value="2">уголовное</option>
                                            <option value="3">административное</option>
                                            <option value="4">арбитраж</option>
                                            <option value="5">кодекс админ. судопр-ва</option>
                                            <option value="6">иное</option>
                                        </select>
                                    </fieldset>
                                </fieldset> 
                                <fieldset class="cont_mainpoint_case">            
                                    <legend>Суть дела</legend>
                                    <textarea name="MAINPOINT" cols="35" rows="10" class="MAINPOINT"></textarea>
                                </fieldset>
                                <fieldset class="cont_rulesoflaw_case">        
                                    <legend>Нормы права</legend>
                                    <textarea name="RULESOFLAW" cols="35" rows="10" class="RULESOFLAW"></textarea>
                                </fieldset>
                                <fieldset class="cont_caseparts_case">        
                                    <legend>Участники дела</legend>   
                                    <textarea name="CASEPARTS" cols="35" rows="10" class="CASEPARTS"></textarea>
                                </fieldset>
                                <fieldset class="cont_contract_case">        
                                    <fieldset class="cont_CASEDATE">
                                        <legend>Дата договора</legend> 
                                        <input type="date" class="CASEDATE" name="CASEDATE"/>
                                    </fieldset>
                                    <fieldset class="cont_CONTRACTSUM">
                                        <legend>Сумма</legend> 
                                        <input type="number" class="CONTRACTSUM" name="CONTRACTSUM"/>
                                    </fieldset>
                                    <fieldset class="cont_CASEDATE">
                                        <legend>Номер договора</legend> 
                                        <input maxlength="50" class="CONTRACTNUM" name="CONTRACTNUM"/>
                                    </fieldset>
                                    <fieldset class="cont_PAYDATE">
                                        <legend>Оплата до</legend> 
                                        <input type="date" class="PAYDATE" name="PAYDATE"/>
                                    </fieldset>        
                                </fieldset>
                                <fieldset class="cont_notes_case">        
                                    <legend>Примечания</legend>    
                                    <textarea name="NOTES" cols="35" rows="10" class="NOTES"></textarea>
                                </fieldset>
                                <fieldset class="buttons_case"> 
                                    <input type="submit" class="submit_case" name="submit_case" value="Сохранить"/>                                     
                                    <button class="cancel_case btn" name="cancel_case" onClick="window.location.href='cases.php';">"Отмена"</button>                                    
                                </fieldset>
                            </form>
                            </div>`;                            
