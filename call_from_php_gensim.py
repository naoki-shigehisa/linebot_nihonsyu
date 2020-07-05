# file name: call_from_php.py
import re
from gensim.models import word2vec

#類似度の高い日本酒を探す関数
def recommend_sake(txt,sake_list,model):
    results = model.wv.most_similar(positive=txt,topn=209127)
    results_sake = []
    for i in range(len(results)):
        if results[i][0] in sake_list:
            return("あなたにオススメの日本酒は" + str(results[i][0]) + "です！")
    return "単語が登録されていませんでした"

#モデル読み込み
model = word2vec.Word2Vec.load("./data/sake.model")

#単語リスト読み込み
with open("./data/sake_list.txt",mode="r",encoding="utf-8") as f:
    sake = f.readline()

#リスト化
sake = sake.split("?n")

if __name__=='__main__':
    text = sys.argv[1]
    text = re.split("[ 　,、]",text)

    message = recommend_sake(text,sake,model)

    print (message)
