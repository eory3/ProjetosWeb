				<div class="form-group">	
					<label for="cod_ingrediente">Ingrediente:</label><br>
					<select name="cod_ingrediente" id="cod_ingrediente" class="form-control" >
						<option value=''>Selecione uma categoria</option>
						<?php
							$r = $pdo->query("select * from ingredientes order by descricao");		
							while($d = $r->fetch(PDO::FETCH_ASSOC)) 
							{								
								echo "<option value='$d[cod_ingrediente]'  $s > $d[descricao] </option>";
							}
						?>
					</select>
					<div id="div_erro_cod_ingrediente"></div>
				</div>

				<div class="form-group">	
					<label for="qde">Quantidade:</label><br>
					<input type="text" name="qde" id="qde" maxlength="100" class="form-control"  placeholder="Quantidade do ingrediente">
					<div id="div_erro_qde"></div>
				</div>

				<a href="javascript:incluir_itens_compra(<?php echo $cod_compra; ?>);"  class="btn btn-success">Incluir</a>
				<p></p>
