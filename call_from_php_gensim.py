# file name: call_from_php.py
import re
from gensim.models import word2vec

def word2vec_list(txt,list_,model):
    results = model.wv.most_similar(positive=txt,topn=209127)
    results_sake = []
    for i in range(len(results)):
        if results[i][0] in list_:
            results_sake.append(results[i])
            if len(results_sake) > 9:
                return results_sake
    return results_sake

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

    try:
        result = word2vec_list(text,sake,model)[0][0]
        out = "あなたにオススメの日本酒は"+result+"です！"
    except:
        out = "単語が登録されていませんでした"   

    print (out)
