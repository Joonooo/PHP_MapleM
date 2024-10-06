<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>캐릭터 정보 조회</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.fade-in {
			animation: fadeIn 0.5s;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
			}

			to {
				opacity: 1;
			}
		}

		.result-container {
			display: none;
			margin-top: 20px;
		}

		.result-card {
			background-color: #f8f9fa;
			border: 1px solid #e9ecef;
			border-radius: 5px;
			padding: 20px;
			margin-bottom: 20px;
		}

		.item-group {
			margin-bottom: 20px;
		}

		.item-name {
			font-weight: bold;
			color: #495057;
		}

		.item-detail {
			margin-left: 20px;
			color: #6c757d;
		}

		.card-title {
			color: #007bff;
			margin-bottom: 15px;
		}

		.card-body>div {
			margin-bottom: 10px;
			line-height: 1.5;
		}

		.card-body>div:last-child {
			margin-bottom: 0;
		}

		.card-body strong {
			color: #495057;
		}
	</style>
	<?php include 'footer.php'; ?>
</head>

<body>
	<div class="container mt-5">
		<h2 class="mb-4">캐릭터 정보 조회</h2>
		<form id="characterForm">
			<div class="mb-3">
				<label for="characterName" class="form-label">캐릭터 명</label>
				<input type="text" class="form-control" id="characterName" placeholder="캐릭터 명을 입력하세요" required>
			</div>
			<div class="mb-3">
				<label for="worldName" class="form-label">월드 명</label>
				<select class="form-select" id="worldName" required>
					<option value="스카니아">스카니아</option>
					<option value="아케인">아케인</option>
					<option value="크로아">크로아</option>
					<option value="엘리시움">엘리시움</option>
					<option value="루나">루나</option>
					<option value="유니온">유니온</option>
					<option value="제니스">제니스</option>
				</select>
			</div>
			<button type="button" class="btn btn-primary" onclick="submitCharacterForm()">조회</button>
		</form>
		<div id="result" class="result-container mt-3" style="display: block;"></div>
		<div id="result2" class="result-container mt-3" style="display: block;"></div>
		<div id="result3" class="result-container mt-3" style="display: block;"></div>
		<div id="result4" class="result-container mt-3" style="display: block;"></div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		// 시간 형식 변환 함수
		function formatDateTime(dateTimeStr) {
			const date = new Date(dateTimeStr);
			return date.toLocaleString();
		}

		// 성별 변환 함수
		function formatGender(genderStr) {
			return genderStr === 'Male' ? '남성' : '여성';
		}

		function fecthAndinnerHTML(fileName, infoHtml, resultContainer) {
			fetch(`./${fileName}?ocid=${ocid}`)
				.then(response => response.json())
				.then(datas => {
					resultContainer.innerHTML = infoHtml;
				})
				.catch(error => {
					resultContainer.innerHTML = `<div class="alert alert-danger fade-in" role="alert">오류가 발생했습니다 ${error}</div>`;
				});
		}
		
		function submitCharacterForm() {
			var characterName = document.getElementById('characterName').value;
			var worldName = document.getElementById('worldName').value;

			var ocid = "";

			var resultContainer = document.getElementById('result');
			var resultContainer2 = document.getElementById('result2');
			var resultContainer3 = document.getElementById('result3');
			var resultContainer4 = document.getElementById('result4');
			resultContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">로딩 중...</span></div><p class="mt-2">캐릭터 정보를 불러오는 중...</p></div>';
			resultContainer2.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">로딩 중...</span></div><p class="mt-2">장착 아이템 정보를 불러오는 중...</p></div>';
			resultContainer3.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">로딩 중...</span></div><p class="mt-2">스탯 정보를 불러오는 중...</p></div>';
			resultContainer4.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">로딩 중...</span></div><p class="mt-2">길드 정보를 불러오는 중...</p></div>';

			// 서버 측 PHP 스크립트로 요청
			fetch(`./fetchCharacterId.php?character_name=${characterName}&world_name=${worldName}`)
				.then(response => response.json())
				.then(data => {
					// 서버 측 PHP 스크립트로 요청
					ocid = data.ocid;
					fetch(`./fetchCharacterBasic.php?ocid=${ocid}`)
						.then(response => response.json())
						.then(data => {
							const infoHtml = `
								<div class="result-card fade-in">
									<h5 class="card-title">캐릭터 정보</h5>
									<div class="card-body">
										<div><strong>캐릭터 명:</strong> ${data.character_name}</div>
										<div><strong>월드 명:</strong> ${data.world_name}</div>
										<div><strong>캐릭터 생성일:</strong> ${formatDateTime(data.character_date_create)}</div>
										<div><strong>마지막 로그인:</strong> ${formatDateTime(data.character_date_last_login)}</div>
										<div><strong>마지막 로그아웃:</strong> ${formatDateTime(data.character_date_last_logout)}</div>
										<div><strong>직업:</strong> ${data.character_job_name}</div>
										<div><strong>성별:</strong> ${formatGender(data.character_gender)}</div>
										<div><strong>경험치:</strong> ${data.character_exp.toLocaleString()}</div>
										<div><strong>레벨:</strong> ${data.character_level}</div>
									</div>
								</div>
							`;
							resultContainer.innerHTML = infoHtml;

							// 서버 측 PHP 스크립트로 요청
							fetch(`./fetchCharacterItem.php?ocid=${ocid}`)
								.then(response => response.json())
								.then(datas => {
									datas = datas['item_equipment'];
									infoHtml2 = `<div class="result-card fade-in"><h5 class="card-title">장착 아이템 정보</h5><div class="card-body">`;
									for (let data of datas) {
										infoHtml2 += `
											<div class="item-group">
												<div class="item-name">${data.item_name}</div>
												<div class="item-detail">${data.item_equipment_slot_name}</div>
											</div>
										`
									}
									infoHtml2 += `</div></div>`
									resultContainer2.innerHTML = infoHtml2;

									// 서버 측 PHP 스크립트로 요청
									fetch(`./fetchCharacterStat.php?ocid=${ocid}`)
										.then(response => response.json())
										.then(datas => {
											datas = datas['stat'];
											infoHtml3 = `<div class="result-card fade-in"><h5 class="card-title">스탯 정보</h5><div class="card-body">`;
											for (let data of datas) {
												infoHtml3 += `
											<div class="item-group">
												<div class="item-name">${data.stat_name}</div>
												<div class="item-detail">${data.stat_value}</div>
											</div>
										`
											}
											infoHtml3 += `</div></div>`
											resultContainer3.innerHTML = infoHtml3;

											// 서버 측 PHP 스크립트로 요청
											fetch(`./fetchCharacterGuild.php?ocid=${ocid}`)
												.then(response => response.json())
												.then(datas => {
													guild_name = datas['guild_name'];
													const infoHtml4 = `
														<div class="result-card fade-in">
															<h5 class="card-title">길드 이름</h5>
															<div class="card-body">
																<div><strong>${guild_name}</strong></div>
															</div>
														</div>
													`;
													resultContainer4.innerHTML = infoHtml4;
												})
												.catch(error => {
													resultContainer4.innerHTML = `<div class="alert alert-danger fade-in" role="alert">오류가 발생했습니다 ${error}</div>`;
												});
										})
										.catch(error => {
											resultContainer3.innerHTML = `<div class="alert alert-danger fade-in" role="alert">오류가 발생했습니다 ${error}</div>`;
										});
								})
								.catch(error => {
									resultContainer2.innerHTML = `<div class="alert alert-danger fade-in" role="alert">오류가 발생했습니다 ${error}</div>`;
								});
						})
						.catch(error => {
							resultContainer.innerHTML = `<div class="alert alert-danger fade-in" role="alert">오류가 발생했습니다</div>`;
						});
				})
				.catch(error => {
					resultContainer.innerHTML = `<div class="alert alert-danger fade-in" role="alert">오류가 발생했습니다</div>`;
				});
		}
	</script>
</body>
<?php include 'footer.php'; ?>
</html>