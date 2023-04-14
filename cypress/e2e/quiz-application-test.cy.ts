describe("シナリオテスト", () => {
  it("クイズプレイ画面に遷移", () => {
    cy.visit("http://localhost/quiz-management");
    cy.get("#btnAdd").click();
    cy.get("#questionTextarea").type("問題文のテスト");
    cy.get("#answer-A").type("Aの回答テスト");
    cy.get("#answer-B").type("Bの回答テスト");
    cy.get("#answer-C").type("Cの回答テスト");
    cy.get("#answer-D").type("Dの回答テスト");
    cy.get("#correctAnswerSelect").select("A");
    cy.get("#explanationTextarea").type("説明のテスト");
    cy.get("#btnAdd").click();
  });
});
