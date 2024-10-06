<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>캐릭터 스탯 정보 조회</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="./css/common.css">
	<?php include 'header.php'; ?>
</head>

<body>
	<div class="container mt-5">
		<h2 class="mb-4">캐릭터 스탯 정보 조회</h2>
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
			<div class="button-container">
				<button type="button" class="btn btn-primary mt-2" onclick="submitCharacterForm()">조회</button>
			</div>
		</form>
		<div id="result" class="result-container mt-3" style="display: block;"></div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		document.getElementById('characterName').addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				event.preventDefault();
				submitCharacterForm();
			}
		});

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
			resultContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">로딩 중...</span></div><p class="mt-2">캐릭터 정보를 불러오는 중...</p></div>';

			// 서버 측 PHP 스크립트로 요청
			fetch(`./fetchCharacterId.php?character_name=${characterName}&world_name=${worldName}`)
				.then(response => response.json())
				.then(data => {
					ocid = data.ocid;
					// 서버 측 PHP 스크립트로 요청
					fetch(`./fetchCharacterStat.php?ocid=${ocid}`)
						.then(response => response.json())
						.then(datas => {
							datas = datas['stat'];
							infoHtml = `<div class="result-card fade-in"><h5 class="card-title">스탯 정보</h5><div class="card-body">`;
							for (let data of datas) {
								infoHtml += `
							<div class="item-group">
								<div class="item-name">${data.stat_name}</div>
								<div class="item-detail">${data.stat_value}</div>
							</div>
						`
							}
							infoHtml += `</div></div>`
							resultContainer.innerHTML = infoHtml;
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