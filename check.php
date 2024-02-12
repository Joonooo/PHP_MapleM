<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>캐릭터 조회</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.result-container {
			display: none;
		}
	</style>
</head>

<body>
	<div class="container mt-5">
		<h2 class="mb-4">캐릭터 조회</h2>
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
		<div id="result" class="result-container mt-3"></div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

	<script>
		function submitCharacterForm() {
			var characterName = document.getElementById('characterName').value;
			var worldName = document.getElementById('worldName').value;

			// 결과 컨테이너와 로딩 스피너 표시
			var resultContainer = document.getElementById('result');
			resultContainer.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">로딩 중...</span></div>';
			resultContainer.style.display = 'block';

			// 서버 측 PHP 스크립트로 요청
			fetch(`./fetchCharacterId.php?character_name=${characterName}&world_name=${worldName}`)
				.then(response => response.json())
				.then(data => {
					// 성공적으로 데이터를 받아오면 결과를 표시합니다.
					resultContainer.innerHTML = `<strong>OCID:</strong> ${data.ocid}`;
					console.log(data);
				})
				.catch(error => {
					// 에러 처리
					resultContainer.innerHTML = `오류가 발생했습니다: ${error}`;
				});
		}
	</script>
</body>

</html>